<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$email = '';
$first_name = $last_name = '';

$memo = [];
$profile_pic = '';

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT u.email, u.profile_pic, u.memo, p.first_name, p.last_name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $email = $row['email'];
    $profile_pic = $row['profile_pic'];
    $memo = json_decode($row['memo'] ?? '{}', true);
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
  }
} else {
  require_permission('users','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

?>
<h2 class="mb-4"><?php echo $id ? 'Edit' : 'Create'; ?> User</h2>
<form action="functions/save.php" method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  <?php if ($id): ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" <?php echo $id ? '' : 'required'; ?>>
  </div>
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Profile Picture</label>
    <input type="file" name="profile_pic" accept="image/png,image/jpeg" class="form-control">
  </div>
  <button class="btn btn-success" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>

<?php require '../admin_footer.php'; ?>
