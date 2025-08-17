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
 $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
 $password = $_POST['password'] ?? '';
 $first_name = trim($_POST['first_name'] ?? '');
 $last_name = trim($_POST['last_name'] ?? '');
 $memo = $_POST['memo'] ?? null;

 $errors = [];
 if ($email === '') {
   $errors[] = 'Valid email required';
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
   $fields = 'email = :email, memo = :memo, user_updated = :uid';
   $params = [
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

   $pstmt = $pdo->prepare('UPDATE person SET first_name = :fn, last_name = :ln, user_updated = :uid WHERE user_id = :uid_fk');
   $pstmt->execute([':fn' => $first_name, ':ln' => $last_name, ':uid' => $this_user_id, ':uid_fk' => $id]);
 } else {
   $sql = 'INSERT INTO users (user_id, user_updated, email, password, profile_pic, memo) VALUES (:uid, :uid, :email, :password, :pic, :memo)';
   $stmt = $pdo->prepare($sql);
   $stmt->execute([
     ':uid' => $this_user_id,
     ':email' => $email,
     ':password' => $hash,
     ':pic' => $profilePath,
     ':memo' => $memo
   ]);
   $id = $pdo->lastInsertId();

   $pstmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, user_updated) VALUES (:uid_fk, :fn, :ln, :uid)');
   $pstmt->execute([':uid_fk' => $id, ':fn' => $first_name, ':ln' => $last_name, ':uid' => $this_user_id]);
 }

 header('Location: ../index.php');
 exit;
