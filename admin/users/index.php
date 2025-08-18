<?php
require '../admin_header.php';

require_permission('users','view');

$users = $pdo->query('SELECT u.id, u.email, p.first_name, p.last_name FROM users u LEFT JOIN person p ON p.user_id = u.id ORDER BY u.email')->fetchAll(PDO::FETCH_ASSOC);
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<h2 class="mb-4">Users</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-success mb-3">Add User</a>
<table class="table table-striped">
  <thead><tr><th>Email</th><th>First Name</th><th>Last Name</th><th></th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td><?php echo htmlspecialchars($u['email']); ?></td>
      <td><?php echo htmlspecialchars($u['first_name']); ?></td>
      <td><?php echo htmlspecialchars($u['last_name']); ?></td>
      <td><a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require '../admin_footer.php'; ?>
