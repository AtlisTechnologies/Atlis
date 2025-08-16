<?php
if (!defined('IN_APP')) { define('IN_APP', true); }
require '../admin_header.php';
require_permission('users','create');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$id = 0;
$username = $email = $first_name = $last_name = $type = 'ADMIN';
$status = 1;
$assigned = [];
$message = $error = '';
$btnClass = 'btn-success';

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$roleColors = array_column(get_lookup_items($pdo, 'ADMIN_ROLE_BADGES'), 'color_class', 'code');

$typeItems   = get_lookup_items($pdo, 'USER_TYPE');
$typeOptions = array_column($typeItems, 'label', 'code');
$typeColors  = array_column($typeItems, 'color_class', 'code');

$statusItems   = get_lookup_items($pdo, 'USER_STATUS');
$statusOptions = array_column($statusItems, 'label', 'code');
$statusColors  = array_column($statusItems, 'color_class', 'code');

$type = array_key_first($typeOptions) ?? $type;
$status = (int)(array_key_first($statusOptions) ?? $status);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $postData = $_POST; // consolidated data from wizard steps
  if (!hash_equals($token, $postData['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $username = trim($postData['username'] ?? '');
  $email = trim($postData['email'] ?? '');
  $password = $postData['password'] ?? '';
  $type = $postData['type'] ?? array_key_first($typeOptions);
  if (!array_key_exists($type, $typeOptions)) {
    $type = array_key_first($typeOptions);
  }
  $status = $postData['status'] ?? array_key_first($statusOptions);
  if (!array_key_exists($status, $statusOptions)) {
    $status = array_key_first($statusOptions);
  }
  $status = (int)$status;
  $first_name = trim($postData['first_name'] ?? '');
  $last_name = trim($postData['last_name'] ?? '');
  $roleIds = $postData['roles'] ?? [];

  if ($username === '' || $email === '' || $password === '') {
    $error = 'Username, email and password are required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Invalid email address.';
  } else {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
    $stmt->execute([':username'=>$username]);
    if ($stmt->fetchColumn()) {
      $error = 'Username already exists.';
    }
    if (!$error) {
      $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
      $stmt->execute([':email'=>$email]);
      if ($stmt->fetchColumn()) {
        $error = 'Email already exists.';
      }
    }
  }

  if (!$error) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (user_id, user_updated, username, email, password, type, status) VALUES (:uid, :uid, :username, :email, :password, :type, :status)');
    $stmt->execute([':uid'=>$this_user_id, ':username'=>$username, ':email'=>$email, ':password'=>$hash, ':type'=>$type, ':status'=>$status]);
    $newId = $pdo->lastInsertId();
    audit_log($pdo, $this_user_id, 'users', $newId, 'CREATE', 'Created user');
    $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
    $stmt->execute([':user_id'=>$newId, ':first_name'=>$first_name, ':last_name'=>$last_name, ':uid'=>$this_user_id]);
    audit_log($pdo, $this_user_id, 'person', $pdo->lastInsertId(), 'CREATE', 'Created person for user');
    foreach($roleIds as $roleId){
      $stmt = $pdo->prepare('INSERT INTO admin_user_roles (user_id, user_updated, user_account_id, role_id) VALUES (:uid, :uid, :uid_account, :role_id)');
      $stmt->execute([':uid'=>$this_user_id, ':uid_account'=>$newId, ':role_id'=>$roleId]);
    }
    if ($roleIds) {
      audit_log($pdo, $this_user_id, 'admin_user_roles', $newId, 'CREATE', 'Assigned roles to user');
    }
    $message = 'User created.';
    $username = $email = $first_name = $last_name = '';
    $assigned = [];
  }
}
?>
<h2 class="mb-4">Add User</h2>
<?php if($error){ echo '<div class="alert alert-danger">'.htmlspecialchars($error).'</div>'; } ?>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<?php include 'form_new.php'; ?>
<?php require '../admin_footer.php'; ?>
