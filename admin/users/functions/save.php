<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/php_header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$username = trim($_POST['username'] ?? '');
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
$password = $_POST['password'] ?? '';
$billing_address = trim($_POST['billing_address'] ?? '');
$billing_city = trim($_POST['billing_city'] ?? '');
$billing_state = trim($_POST['billing_state'] ?? '');
$billing_zip = trim($_POST['billing_zip'] ?? '');
$billing_card = trim($_POST['billing_card'] ?? '');

$errors = [];
if ($username === '') {
  $errors[] = 'Username required';
}
if ($email === '') {
  $errors[] = 'Valid email required';
}
if ($billing_zip !== '' && !preg_match('/^\d{5}(-\d{4})?$/', $billing_zip)) {
  $errors[] = 'Invalid billing ZIP';
}

// check email uniqueness
$check = $pdo->prepare('SELECT id FROM users WHERE email = :email AND id <> :id');
$check->execute([':email' => $email, ':id' => $id]);
if ($check->fetch()) {
  $errors[] = 'Email already exists';
}

if (!$id && $password === '') {
  $errors[] = 'Password required';
}

if ($errors) {
  $_SESSION['form_errors'] = $errors;
  $redir = '../edit.php';
  if ($id) { $redir .= '?id=' . $id; }
  header('Location: ' . $redir);
  exit;
}

$hash = $password !== '' ? password_hash($password, PASSWORD_DEFAULT) : null;

// tokenise billing card
$billing_token = $billing_card !== '' ? hash('sha256', $billing_card) : '';
$memo = json_encode([
  'billing_address' => $billing_address,
  'billing_city' => $billing_city,
  'billing_state' => $billing_state,
  'billing_zip' => $billing_zip,
  'billing_token' => $billing_token
]);

$profilePath = null;
if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
  $file = $_FILES['profile_pic'];
  if ($file['size'] <= 400 * 1024) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg', 'image/png'];
    $img = @getimagesize($file['tmp_name']);
    if (in_array($mime, $allowed, true) && $img && $img[0] == 300 && $img[1] == 300) {
      $ext = $mime === 'image/png' ? 'png' : 'jpg';
      $safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
      $filename = $safe . '_' . time() . '.' . $ext;
      $destDir = '../../../module/users/uploads/';
      if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
      }
      $dest = $destDir . $filename;
      if (move_uploaded_file($file['tmp_name'], $dest)) {
        $profilePath = 'module/users/uploads/' . $filename;
      }
    }
  }
}

if ($id) {
  $fields = 'username = :username, email = :email, memo = :memo, user_updated = :uid';
  $params = [
    ':username' => $username,
    ':email' => $email,
    ':memo' => $memo,
    ':uid' => $this_user_id,
    ':id' => $id
  ];
  if ($hash) { $fields .= ', password = :password'; $params[':password'] = $hash; }
  if ($profilePath) { $fields .= ', profile_pic = :pic'; $params[':pic'] = $profilePath; }
  $sql = 'UPDATE users SET ' . $fields . ' WHERE id = :id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
} else {
  $sql = 'INSERT INTO users (user_id, user_updated, username, email, password, profile_pic, memo) VALUES (:uid, :uid, :username, :email, :password, :pic, :memo)';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':uid' => $this_user_id,
    ':username' => $username,
    ':email' => $email,
    ':password' => $hash,
    ':pic' => $profilePath,
    ':memo' => $memo
  ]);
  $id = $pdo->lastInsertId();
}

header('Location: ../index.php');
exit;
