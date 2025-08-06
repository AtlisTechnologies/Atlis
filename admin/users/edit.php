<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $email = $first_name = $last_name = $type = 'ADMIN';
$status = 1;
$assigned = [];
$message = $error = '';

if ($id) {
  $stmt = $pdo->prepare('SELECT u.username, u.email, u.type, u.status, p.first_name, p.last_name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username = $row['username'];
    $email = $row['email'];
    $type = $row['type'];
    $status = $row['status'];
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
  }
  $stmt = $pdo->prepare('SELECT role_id FROM admin_user_roles WHERE user_account_id = :id');
  $stmt->execute([':id' => $id]);
  $assigned = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';
  $type = $_POST['type'] ?? 'ADMIN';
  $status = isset($_POST['status']) ? (int)$_POST['status'] : 0;
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');
  $roleIds = $_POST['roles'] ?? [];

  if ($username === '' || $email === '') {
    $error = 'Username and email are required.';
  }
  if (!$id && $password === '') {
    $error = 'Password is required for new users.';
  }

  if (!$error) {
    if ($id) {
      if ($password !== '') {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email, password=:password, type=:type, status=:status, user_updated=:uid WHERE id=:id');
        $stmt->execute([':username'=>$username, ':email'=>$email, ':password'=>$hash, ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
      } else {
        $stmt = $pdo->prepare('UPDATE users SET username=:username, email=:email, type=:type, status=:status, user_updated=:uid WHERE id=:id');
        $stmt->execute([':username'=>$username, ':email'=>$email, ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
      }
      audit_log($pdo, $this_user_id, 'users', $id, 'UPDATE', 'Updated user');
      $stmt = $pdo->prepare('SELECT id FROM person WHERE user_id = :id');
      $stmt->execute([':id' => $id]);
      if ($stmt->fetchColumn()) {
        $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name, last_name=:last_name, user_updated=:uid WHERE user_id=:id');
        $stmt->execute([':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id, ':id'=>$id]);
      } else {
        $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
        $stmt->execute([':user_id'=>$id, ':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id]);
      }
      $stmt = $pdo->prepare('DELETE FROM admin_user_roles WHERE user_account_id = :id');
      $stmt->execute([':id' => $id]);
      foreach($roleIds as $roleId){
        $stmt = $pdo->prepare('INSERT INTO admin_user_roles (user_id, user_updated, user_account_id, role_id) VALUES (:uid, :uid, :uid_account, :role_id)');
        $stmt->execute([':uid'=>$this_user_id, ':uid_account'=>$id, ':role_id'=>$roleId]);
      }
      audit_log($pdo, $this_user_id, 'admin_user_roles', $id, 'UPDATE', 'Updated user roles');
      $message = 'User updated.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare('INSERT INTO users (user_id, user_updated, username, email, password, type, status) VALUES (:uid, :uid, :username, :email, :password, :type, :status)');
      $stmt->execute([':uid'=>$this_user_id, ':username'=>$username, ':email'=>$email, ':password'=>$hash, ':type'=>$type, ':status'=>$status]);
      $id = $pdo->lastInsertId();
      audit_log($pdo, $this_user_id, 'users', $id, 'CREATE', 'Created user');
      $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
      $stmt->execute([':user_id'=>$id, ':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id]);
      audit_log($pdo, $this_user_id, 'person', $pdo->lastInsertId(), 'CREATE', 'Created person for user');
      foreach($roleIds as $roleId){
        $stmt = $pdo->prepare('INSERT INTO admin_user_roles (user_id, user_updated, user_account_id, role_id) VALUES (:uid, :uid, :uid_account, :role_id)');
        $stmt->execute([':uid'=>$this_user_id, ':uid_account'=>$id, ':role_id'=>$roleId]);
      }
      if ($roleIds) {
        audit_log($pdo, $this_user_id, 'admin_user_roles', $id, 'CREATE', 'Assigned roles to user');
      }
      $message = 'User created.';
    }
  }
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> User</h2>
<?php if($error){ echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($username); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Password <?= $id ? '(leave blank to keep current)' : ''; ?></label>
    <input type="password" class="form-control" name="password" <?= $id ? '' : 'required'; ?>>
  </div>
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($first_name); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($last_name); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Type</label>
    <select class="form-select" name="type">
      <option value="ADMIN" <?= $type === 'ADMIN' ? 'selected' : ''; ?>>Admin</option>
      <option value="USER" <?= $type === 'USER' ? 'selected' : ''; ?>>User</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select class="form-select" name="status">
      <option value="1" <?= $status ? 'selected' : ''; ?>>Active</option>
      <option value="0" <?= !$status ? 'selected' : ''; ?>>Inactive</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Roles</label>
    <?php foreach($roles as $r): ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>" id="role<?= $r['id']; ?>" <?= in_array($r['id'], $assigned) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="role<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?></label>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
<?php require '../admin_footer.php'; ?>
