<?php
require '../admin_header.php';
require_permission('users','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = $_GET['msg'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  require_permission('users','delete');
  $delId = (int)$_POST['delete_id'];
  $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
  $stmt->execute([':id' => $delId]);
  admin_audit_log($pdo, $this_user_id, 'users', $delId, 'DELETE', null, null, 'Deleted user');
  $message = 'User deleted.';
}

$stmt = $pdo->query('SELECT id, username, email, type, status FROM users ORDER BY username');
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Users</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-sm btn-success mb-3">Add User</a>
<div id="users" data-list='{"valueNames":["id","username","email","type","status"],"page":25,"pagination":true}'>
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
          <th class="sort" data-sort="username">Username</th>
          <th class="sort" data-sort="email">Email</th>
          <th class="sort" data-sort="type">Type</th>
          <th class="sort" data-sort="status">Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($users as $u): ?>
        <tr>
          <td class="id"><?= htmlspecialchars($u['id']); ?></td>
          <td class="username"><?= htmlspecialchars($u['username']); ?></td>
          <td class="email"><?= htmlspecialchars($u['email']); ?></td>
          <td class="type"><?= htmlspecialchars($u['type']); ?></td>
          <td class="status"><?= $u['status'] ? 'Active' : 'Inactive'; ?></td>
          <td>
            <a class="btn btn-sm btn-warning" href="edit.php?id=<?= $u['id']; ?>">Edit</a>
            <form method="post" class="d-inline">
              <input type="hidden" name="delete_id" value="<?= $u['id']; ?>">
              <input type="hidden" name="csrf_token" value="<?= $token; ?>">
              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?');">Delete</button>
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
