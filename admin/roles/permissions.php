<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM admin_permissions WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'admin_permissions', $delId, 'DELETE', null, null, 'Deleted permission');
  $message = 'Permission deleted.';
}

$stmt = $pdo->query('SELECT id, module, action FROM admin_permissions ORDER BY module, action');
$perms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Permissions</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="permission_edit.php" class="btn btn-sm btn-primary mb-3">Add Permission</a>
<div id="permissions" data-list='{"valueNames":["id","module","action"],"page":10,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="module">Module</th>
          <th class="sort" data-sort="action">Action</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($perms as $p): ?>
          <tr>
            <td class="id"><?= htmlspecialchars($p['id']); ?></td>
            <td class="module"><?= htmlspecialchars($p['module']); ?></td>
            <td class="action"><?= htmlspecialchars($p['action']); ?></td>
            <td>
              <a class="btn btn-sm btn-secondary" href="permission_edit.php?id=<?= $p['id']; ?>">Edit</a>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_id" value="<?= $p['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this permission?');">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
