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
 $isUpdate = $id > 0;
 $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL) ?: '';
 $password = $_POST['password'] ?? '';
 $confirm = $_POST['confirmPassword'] ?? '';
 $first_name = trim($_POST['first_name'] ?? '');
 $last_name = trim($_POST['last_name'] ?? '');
 $gender_id = isset($_POST['gender_id']) && $_POST['gender_id'] !== '' ? (int)$_POST['gender_id'] : null;
 $phone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
 $dob = $_POST['dob'] ?? '';
 $address = trim($_POST['address'] ?? '');
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

if (!$isUpdate && $password === '') {
  $errors[] = 'Password required';
}
if ($password !== '' && $password !== $confirm) {
  $errors[] = 'Passwords do not match';
}

 if ($dob !== '') {
   $dt = DateTime::createFromFormat('Y-m-d', $dob);
   if (!$dt || $dt->format('Y-m-d') !== $dob) {
     $errors[] = 'Invalid date of birth';
   }
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
$oldProfile = null;
if ($isUpdate) {
  $stmt = $pdo->prepare('SELECT profile_pic FROM users WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $oldProfile = $stmt->fetchColumn();
}
if (!empty($_FILES['profile_pic']['name']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
  $file = $_FILES['profile_pic'];
  if ($file['size'] <= 10 * 1024 * 1024) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);
    $allowed = ['image/jpeg', 'image/png'];
    if (in_array($mime, $allowed, true)) {
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
        if ($oldProfile && file_exists('../../../' . $oldProfile)) {
          @unlink('../../../' . $oldProfile);
        }
      }
    }
  }
}

 try {
   if ($isUpdate) {
     $fields = 'email = :email, memo = :memo, user_updated = :uid';
     $params = [
       ':email' => $email,
       ':memo' => $memo,
       ':uid' => $this_user_id,
       ':id' => $id
     ];
     if ($hash) { $fields .= ', password = :password'; $params[':password'] = $hash; }
     if ($profilePath) { $fields .= ', profile_pic = :pic'; $params[':pic'] = $profilePath; }
     $stmt = $pdo->prepare('UPDATE users SET ' . $fields . ' WHERE id = :id');
     $stmt->execute($params);

     $personExists = $pdo->prepare('SELECT id FROM person WHERE user_id = :uid_fk');
     $personExists->execute([':uid_fk' => $id]);
     $personParams = [
       ':uid_fk' => $id,
       ':fn' => $first_name,
       ':ln' => $last_name,
       ':gender_id' => $gender_id,
       ':phone' => $phone,
       ':dob' => $dob ?: null,
       ':address' => $address,
       ':uid_update' => $this_user_id
     ];
     if ($personExists->fetchColumn()) {
       $pstmt = $pdo->prepare('UPDATE person SET first_name = :fn, last_name = :ln, gender_id = :gender_id, phone = :phone, dob = :dob, address = :address, user_updated = :uid_update WHERE user_id = :uid_fk');
       $pstmt->execute($personParams);
     } else {
       $pstmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, gender_id, phone, dob, address, user_updated) VALUES (:uid_fk, :fn, :ln, :gender_id, :phone, :dob, :address, :uid_update)');
       $pstmt->execute($personParams);
     }
   } else {
     $stmt = $pdo->prepare('INSERT INTO users (user_id, user_updated, email, password, profile_pic, memo) VALUES (:uid, :uid, :email, :password, :pic, :memo)');
     $stmt->execute([
       ':uid' => $this_user_id,
       ':email' => $email,
       ':password' => $hash,
       ':pic' => $profilePath,
       ':memo' => $memo
     ]);
     $id = (int)$pdo->lastInsertId();

     $pstmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, gender_id, phone, dob, address, user_updated) VALUES (:uid_fk, :fn, :ln, :gender_id, :phone, :dob, :address, :uid_update)');
     $pstmt->execute([
       ':uid_fk' => $id,
       ':fn' => $first_name,
       ':ln' => $last_name,
       ':gender_id' => $gender_id,
       ':phone' => $phone,
       ':dob' => $dob ?: null,
       ':address' => $address,
       ':uid_update' => $this_user_id
     ]);
   }

   $_SESSION['message'] = $isUpdate ? 'User updated.' : 'User created.';
 } catch (Exception $e) {
   $_SESSION['message'] = 'Error saving user.';
 }

 header('Location: ../index.php');
 exit;
