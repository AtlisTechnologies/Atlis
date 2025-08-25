<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$module = '';
$action = '';
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('roles','update');
  $stmt = $pdo->prepare('SELECT module, action FROM admin_permissions WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $module = $row['module'];
    $action = $row['action'];
  }
} else {
  require_permission('roles','create');
}

ensure_org_permission_groups($pdo, $this_user_id);
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $module = trim($_POST['module'] ?? '');
  $action = trim($_POST['action'] ?? '');
  if ($id) {
    $old = json_encode(['module' => $row['module'], 'action' => $row['action']]);
    $stmt = $pdo->prepare('UPDATE admin_permissions SET module = :module, action = :action, user_updated = :uid WHERE id = :id');
    $stmt->execute([':module' => $module, ':action' => $action, ':uid' => $this_user_id, ':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'admin_permissions', $id, 'UPDATE', $old, json_encode(['module'=>$module,'action'=>$action]), 'Updated permission');
  } else {
    $stmt = $pdo->prepare('INSERT INTO admin_permissions (module, action, user_id, user_updated) VALUES (:module, :action, :uid, :uid)');
    $stmt->execute([':module' => $module, ':action' => $action, ':uid' => $this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'admin_permissions', $id, 'CREATE', null, json_encode(['module'=>$module,'action'=>$action]), 'Created permission');
  }
  header('Location: permissions.php');
  exit;
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit Permission' : 'Add Permission'; ?></h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Module</label>
    <input type="text" name="module" class="form-control" value="<?= htmlspecialchars($module); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Action</label>
    <input type="text" name="action" class="form-control" value="<?= htmlspecialchars($action); ?>" required>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="permissions.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require '../admin_footer.php'; ?>
