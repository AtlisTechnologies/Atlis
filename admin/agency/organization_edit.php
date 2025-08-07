<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
    $stmt = $pdo->prepare('UPDATE module_organization SET name = :name, main_person = :main_person, status = :status WHERE id = :id');
    $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':id'=>$id]);
    audit_log($pdo, $this_user_id, 'module_organization', $id, 'UPDATE', 'Updated organization');
    $message = 'Organization updated.';
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_organization (name, main_person, status) VALUES (:name, :main_person, :status)');
    $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status]);
    $id = $pdo->lastInsertId();
    audit_log($pdo, $this_user_id, 'module_organization', $id, 'CREATE', 'Created organization');
    $message = 'Organization added.';
  }
}

if($id && $_SERVER['REQUEST_METHOD'] !== 'POST') {
  $stmt = $pdo->prepare('SELECT name, main_person, status FROM module_organization WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row){
    $name = $row['name'];
    $main_person = $row['main_person'];
    $status = $row['status'];
  }
}

// Fetch status list
$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'ORGANIZATION_STATUS' ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statuses = $statusStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Organization</h2>
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
  <a href="index.php" class="btn btn-phoenix-secondary">Back</a>
</form>
<?php require '../admin_footer.php'; ?>
