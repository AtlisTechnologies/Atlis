<?php
require '../admin_header.php';

require_permission('users','view');

$users = $pdo->query("SELECT u.id, u.email, CONCAT(p.first_name, ' ', p.last_name) AS name, upp.file_path, GROUP_CONCAT(r.name ORDER BY r.name SEPARATOR ', ') AS roles FROM users u LEFT JOIN person p ON p.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN admin_user_roles ur ON u.id = ur.user_account_id LEFT JOIN admin_roles r ON ur.role_id = r.id GROUP BY u.id, u.email, p.first_name, p.last_name, upp.file_path ORDER BY u.email")->fetchAll(PDO::FETCH_ASSOC);
$message = $_SESSION['message'] ?? '';
$error_message = $_SESSION['error_message'] ?? '';
unset($_SESSION['message'], $_SESSION['error_message']);
?>
<h2 class="mb-4">Users</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; }
if($error_message){ echo '<div class="alert alert-danger">'.htmlspecialchars($error_message).'</div>'; } ?>
<a href="edit.php" class="btn btn-success mb-3">Add User</a>
<table class="table table-striped">
  <thead><tr><th>Email</th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td>
        <h4>
          <a href="edit.php?id=<?php echo $u['id']; ?>">
            <img src="<?php if(isset($u['file_path'])){ echo getURLDir() . $u['file_path']; }else{ echo '/_atlis/assets/img/team/avatar.webp';  }?>" class="img-thumbnail" style="width:40px;height:40px;">
            <?php echo htmlspecialchars($u['name']); ?>
          </a>
        </h4>
        <?php echo htmlspecialchars($u['email']); ?>
        <?php if (!empty($u['roles'])): ?>
          <div class="text-body-secondary small"><?php echo h($u['roles']); ?></div>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php require '../admin_footer.php'; ?>
