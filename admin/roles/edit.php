<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$name = '';
$description = '';
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('roles','update');
  $stmt = $pdo->prepare('SELECT name, description FROM admin_roles WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $name = $row['name'];
    $description = $row['description'];
  }
} else {
  require_permission('roles','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $name = trim($_POST['name'] ?? '');
  $description = trim($_POST['description'] ?? '');
  if ($id) {
    $old = json_encode(['name' => $row['name'], 'description' => $row['description']]);
    $stmt = $pdo->prepare('UPDATE admin_roles SET name = :name, description = :description, user_updated = :uid WHERE id = :id');
    $stmt->execute([':name' => $name, ':description' => $description, ':uid' => $this_user_id, ':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'admin_roles', $id, 'UPDATE', $old, json_encode(['name'=>$name,'description'=>$description]), 'Updated role');
  } else {
    $stmt = $pdo->prepare('INSERT INTO admin_roles (name, description, user_id, user_updated) VALUES (:name, :description, :uid, :uid)');
    $stmt->execute([':name' => $name, ':description' => $description, ':uid' => $this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'admin_roles', $id, 'CREATE', null, json_encode(['name'=>$name,'description'=>$description]), 'Created role');
  }
  header('Location: index.php');
  exit;
}
?>
<h2 class="mb-4"><?= $id ? 'Edit Role' : 'Add Role'; ?></h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($description); ?></textarea>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require '../admin_footer.php'; ?>
