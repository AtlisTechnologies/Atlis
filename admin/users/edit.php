<?php
require '../admin_header.php';
require_permission('users','update');
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$errors = [];
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$first_name = trim($_POST['first_name'] ?? '');
$last_name = trim($_POST['last_name'] ?? '');

if ($first_name === '') { $errors['first_name'] = 'First name required'; }
if ($last_name === '') { $errors['last_name'] = 'Last name required'; }
if ($username === '') { $errors['username'] = 'Username required'; }
if ($email === '') { $errors['email'] = 'Email required'; }

if ($errors) {
  echo json_encode(['status' => 'error', 'errors' => $errors]);
  exit;
}

try {
  $pdo->beginTransaction();
  $sql = 'UPDATE users SET username=:username, email=:email';
  $params = [':username' => $username, ':email' => $email, ':uid' => $this_user_id, ':id' => $id];
  if ($password) {
    $sql .= ', password=:password';
    $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
  }
  $sql .= ', user_updated=:uid WHERE id=:id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);

  $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name, last_name=:last_name, user_updated=:uid WHERE user_id=:id');
  $stmt->execute([':first_name' => $first_name, ':last_name' => $last_name, ':uid' => $this_user_id, ':id' => $id]);

  admin_audit_log($pdo, $this_user_id, 'users', $id, 'UPDATE', null, json_encode(['username'=>$username,'email'=>$email]));
  admin_audit_log($pdo, $this_user_id, 'person', $id, 'UPDATE', null, json_encode(['user_id'=>$id,'first_name'=>$first_name,'last_name'=>$last_name]));

  $pdo->commit();
  echo json_encode(['status' => 'success']);
} catch (Exception $e) {
  $pdo->rollBack();
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
