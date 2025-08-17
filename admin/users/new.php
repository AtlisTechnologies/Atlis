<?php
require '../admin_header.php';
require_permission('users','create');
header('Content-Type: application/json');

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

$hash = $password ? password_hash($password, PASSWORD_DEFAULT) : '';

try {
  $pdo->beginTransaction();
  $stmt = $pdo->prepare('INSERT INTO users (username, email, password, user_id, user_updated) VALUES (:username, :email, :password, :uid, :uid)');
  $stmt->execute([':username' => $username, ':email' => $email, ':password' => $hash, ':uid' => $this_user_id]);
  $userId = $pdo->lastInsertId();

  $stmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:user_id, :first_name, :last_name, :uid)');
  $stmt->execute([':user_id' => $userId, ':first_name' => $first_name, ':last_name' => $last_name, ':uid' => $this_user_id]);
  $personId = $pdo->lastInsertId();

  admin_audit_log($pdo, $this_user_id, 'users', $userId, 'CREATE', null, json_encode(['username'=>$username,'email'=>$email]));
  admin_audit_log($pdo, $this_user_id, 'person', $personId, 'CREATE', null, json_encode(['user_id'=>$userId,'first_name'=>$first_name,'last_name'=>$last_name]));

  $pdo->commit();
  echo json_encode(['status' => 'success', 'user_id' => $userId]);
} catch (Exception $e) {
  $pdo->rollBack();
  echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
