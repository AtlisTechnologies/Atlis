<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$agency_id = isset($_GET['agency_id']) ? (int)$_GET['agency_id'] : 0;
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($id) {
    require_permission('orgs','update');
    if (!$agency_id) {
        $stmt = $pdo->prepare('SELECT agency_id FROM module_division WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        $agency_id = (int)$stmt->fetchColumn();
    }
} else {
    require_permission('orgs','create');
    if (!$agency_id) { die('Agency ID required'); }
}

$agencyStmt = $pdo->prepare('SELECT name FROM module_agency WHERE id = :id');
$agencyStmt->execute([':id'=>$agency_id]);
$agency = $agencyStmt->fetch(PDO::FETCH_ASSOC);
if (!$agency) { die('Agency not found'); }

$name = '';
$main_person = null;
$status = null;
$message = '';

if ($id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $stmt = $pdo->prepare('SELECT name, main_person, status FROM module_division WHERE id = :id');
    $stmt->execute([':id'=>$id]);
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $name = $row['name'];
        $main_person = $row['main_person'];
        $status = $row['status'];
    } else {
        die('Division not found');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($token, $_POST['csrf_token'] ?? '')) { die('Invalid CSRF token'); }
    $name = trim($_POST['name'] ?? '');
    $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
    $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
    if ($id) {
        $stmt = $pdo->prepare('UPDATE module_division SET name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:id');
        $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
        admin_audit_log($pdo,$this_user_id,'module_division',$id,'UPDATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Updated division');
        $message = 'Division updated.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO module_division (user_id,user_updated,agency_id,name,main_person,status) VALUES (:uid,:uid,:agency,:name,:main_person,:status)');
        $stmt->execute([':uid'=>$this_user_id, ':agency'=>$agency_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
        $id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_division',$id,'CREATE',null,json_encode(['agency_id'=>$agency_id,'name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Created division');
        header('Location: division.php?id='.$id);
        exit;
    }
}

$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'DIVISION_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4"><?= $id ? 'Edit Division' : 'Add Division'; ?> for <?= htmlspecialchars($agency['name']); ?></h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Main Person ID</label>
    <input type="number" name="main_person" class="form-control" value="<?= htmlspecialchars($main_person); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="">--</option>
      <?php foreach($statuses as $s): ?>
        <option value="<?= $s['id']; ?>" <?= (string)$status === (string)$s['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($s['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
<?php require '../admin_footer.php'; ?>
