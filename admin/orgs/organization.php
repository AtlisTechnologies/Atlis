<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$name = '';
$main_person = null;
$status = null;
$message = '';

if ($id) {
    require_permission('orgs','update');
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $stmt = $pdo->prepare('SELECT name, main_person, status FROM module_organization WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name = $row['name'];
            $main_person = $row['main_person'];
            $status = $row['status'];
        } else {
            die('Organization not found');
        }
    }
} else {
    require_permission('orgs','create');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token');
    }
    $name = trim($_POST['name'] ?? '');
    $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
    $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
    if ($id) {
        $stmt = $pdo->prepare('UPDATE module_organization SET name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:id');
        $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
        admin_audit_log($pdo,$this_user_id,'module_organization',$id,'UPDATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Updated organization');
        $message = 'Organization updated.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO module_organization (user_id,user_updated,name,main_person,status) VALUES (:uid,:uid,:name,:main_person,:status)');
        $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
        $id = $pdo->lastInsertId();
        admin_audit_log($pdo,$this_user_id,'module_organization',$id,'CREATE',null,json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]),'Created organization');
        header('Location: organization.php?id='.$id);
        exit;
    }
}

$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'ORGANIZATION_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch agencies for display when editing
$orgAgencies = [];
if ($id) {
    $agStmt = $pdo->prepare('SELECT id, name FROM module_agency WHERE organization_id = :id ORDER BY name');
    $agStmt->execute([':id'=>$id]);
    $orgAgencies = $agStmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<h2 class="mb-4"><?= $id ? 'Edit Organization' : 'Add Organization'; ?></h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post" class="mb-4">
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
<?php if ($id): ?>
  <h3 class="mb-3">Agencies</h3>
  <a href="agency.php?organization_id=<?= $id; ?>" class="btn btn-sm btn-primary mb-3">Add Agency</a>
  <?php if ($orgAgencies): ?>
    <ul class="list-unstyled">
      <?php foreach ($orgAgencies as $a): ?>
        <li><a href="agency.php?id=<?= $a['id']; ?>"><?= htmlspecialchars($a['name']); ?></a></li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p class="text-muted">No agencies yet.</p>
  <?php endif; ?>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
