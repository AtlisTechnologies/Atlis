<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$organization_id = isset($_GET['organization_id']) ? (int)$_GET['organization_id'] : 0;
if(!$organization_id && $id){
  $stmtOrg = $pdo->prepare('SELECT organization_id FROM module_agency WHERE id = :id');
  $stmtOrg->execute([':id'=>$id]);
  $organization_id = (int)$stmtOrg->fetchColumn();
}
if(!$organization_id){
  die('Organization ID required');
}

$orgStmt = $pdo->prepare('SELECT name FROM module_organization WHERE id = :id');
$orgStmt->execute([':id'=>$organization_id]);
$organization = $orgStmt->fetch(PDO::FETCH_ASSOC);
if(!$organization) { die('Organization not found'); }

$name = '';
$main_person = null;
$status = null;
$message = '';
$btnClass = $id ? 'btn-phoenix-warning' : 'btn-phoenix-success';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  if(!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $name = trim($_POST['name'] ?? '');
  $main_person = !empty($_POST['main_person']) ? (int)$_POST['main_person'] : null;
  $status = !empty($_POST['status']) ? (int)$_POST['status'] : null;
  if($id){
    $stmt = $pdo->prepare('UPDATE module_agency SET name = :name, main_person = :main_person, status = :status WHERE id = :id');
    $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':id'=>$id]);
    audit_log($pdo, $this_user_id, 'module_agency', $id, 'UPDATE', 'Updated agency');
    $message = 'Agency updated.';
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_agency (organization_id, name, main_person, status) VALUES (:organization_id, :name, :main_person, :status)');
    $stmt->execute([':organization_id'=>$organization_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
    $id = $pdo->lastInsertId();
    audit_log($pdo, $this_user_id, 'module_agency', $id, 'CREATE', 'Created agency');
    $message = 'Agency added.';
  }
}

if($id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
  $stmt = $pdo->prepare('SELECT name, main_person, status FROM module_agency WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row){
    $name = $row['name'];
    $main_person = $row['main_person'];
    $status = $row['status'];
  }
}

// Fetch status list
$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'AGENCY_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Agency for <?= htmlspecialchars($organization['name']); ?></h2>
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
        <option value="<?= $s['id']; ?>" <?= $status == $s['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($s['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn <?= $btnClass; ?>">Save</button>
  <a href="agencies.php?organization_id=<?= $organization_id; ?>" class="btn btn-phoenix-secondary">Back</a>
</form>
<?php require '../admin_footer.php'; ?>
