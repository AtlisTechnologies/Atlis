<?php
require '../admin_header.php';

require_permission('users','view');

$users = $pdo->query("SELECT u.id, u.email, CONCAT(p.first_name, ' ', p.last_name) AS name, upp.file_path FROM users u LEFT JOIN person p ON p.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id ORDER BY u.email")->fetchAll(PDO::FETCH_ASSOC);
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>
<h2 class="mb-4">Users</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="edit.php" class="btn btn-success mb-3">Add User</a>
<table class="table table-striped">
  <thead><tr><th>Email</th><th>Name</th><th>Avatar</th><th></th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td><?php echo htmlspecialchars($u['email']); ?></td>
      <td><?php echo htmlspecialchars($u['name']); ?></td>
      <td><img src="<?= getURLDir() . $u['file_path'] ?>" class="img-thumbnail" style="width:40px;height:40px;"></td>
      <td><a href="edit.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-primary">Edit</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require '../admin_footer.php'; ?>
