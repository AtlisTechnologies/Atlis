<?php
require '../admin_header.php';
require_permission('users','view');

$users = $pdo->query('SELECT id, username, email FROM users ORDER BY username')->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Users</h2>
<a href="edit.php" class="btn btn-success mb-3">Add User</a>
<table class="table table-striped">
  <thead><tr><th>Username</th><th>Email</th><th></th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td><?php echo htmlspecialchars($u['username']); ?></td>
      <td><?php echo htmlspecialchars($u['email']); ?></td>
      <td><a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require '../admin_footer.php'; ?>
