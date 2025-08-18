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
 $confirm = $_POST['confirmPassword'] ?? '';
 $first_name = trim($_POST['first_name'] ?? '');
 $last_name = trim($_POST['last_name'] ?? '');
 $gender = trim($_POST['gender'] ?? '');
 $phone = trim($_POST['phone'] ?? '');
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

if (!$id && $password === '') {
  $errors[] = 'Password required';
}
if ($password !== '' && $password !== $confirm) {
  $errors[] = 'Passwords do not match';
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

 try {
   $profileCols = $pdo->query('SHOW COLUMNS FROM person')->fetchAll(PDO::FETCH_COLUMN);
   $hasGender = in_array('gender', $profileCols, true);
   $hasPhone = in_array('phone', $profileCols, true);
   $hasDob = in_array('dob', $profileCols, true);
   $hasAddress = in_array('address', $profileCols, true);

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

     $pfields = ['first_name = :fn', 'last_name = :ln', 'user_updated = :uid'];
     $pparams = [':fn' => $first_name, ':ln' => $last_name, ':uid' => $this_user_id, ':uid_fk' => $id];
     if ($hasGender) { $pfields[] = 'gender = :gender'; $pparams[':gender'] = $gender; }
     if ($hasPhone) { $pfields[] = 'phone = :phone'; $pparams[':phone'] = $phone; }
     if ($hasDob) { $pfields[] = 'dob = :dob'; $pparams[':dob'] = $dob ?: null; }
     if ($hasAddress) { $pfields[] = 'address = :address'; $pparams[':address'] = $address; }
     $pstmt = $pdo->prepare('UPDATE person SET ' . implode(', ', $pfields) . ' WHERE user_id = :uid_fk');
     $pstmt->execute($pparams);
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

     $cols = ['user_id','first_name','last_name','user_updated'];
     $vals = [':uid_fk',':fn',':ln',':uid'];
     $pparams = [':uid_fk' => $id, ':fn' => $first_name, ':ln' => $last_name, ':uid' => $this_user_id];
     if ($hasGender) { $cols[] = 'gender'; $vals[] = ':gender'; $pparams[':gender'] = $gender; }
     if ($hasPhone) { $cols[] = 'phone'; $vals[] = ':phone'; $pparams[':phone'] = $phone; }
     if ($hasDob) { $cols[] = 'dob'; $vals[] = ':dob'; $pparams[':dob'] = $dob ?: null; }
     if ($hasAddress) { $cols[] = 'address'; $vals[] = ':address'; $pparams[':address'] = $address; }
     $pstmt = $pdo->prepare('INSERT INTO person (' . implode(',', $cols) . ') VALUES (' . implode(',', $vals) . ')');
     $pstmt->execute($pparams);
   }

   $_SESSION['message'] = $id ? 'User updated.' : 'User created.';
 } catch (Exception $e) {
   $_SESSION['message'] = 'Error saving user.';
 }

 header('Location: ../index.php');
 exit;
