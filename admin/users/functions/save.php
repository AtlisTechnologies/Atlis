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
$reactivatePicId = isset($_POST['reactivate_pic_id']) ? (int)$_POST['reactivate_pic_id'] : 0;

function get_status_id(PDO $pdo, string $code): int {
  $stmt = $pdo->prepare("SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_PROFILE_PIC_STATUS' AND li.code = :code LIMIT 1");
  $stmt->execute([':code' => $code]);
  return (int)$stmt->fetchColumn();
}

$activeStatusId = get_status_id($pdo, 'ACTIVE');
$inactiveStatusId = get_status_id($pdo, 'INACTIVE');

if ($reactivatePicId && $id) {
  try {
    $pdo->beginTransaction();
    $pdo->prepare('UPDATE users_profile_pics SET status_id = :inactive, user_updated = :uid WHERE user_id = :user AND status_id = :active')
        ->execute([':inactive' => $inactiveStatusId, ':uid' => $this_user_id, ':user' => $id, ':active' => $activeStatusId]);
    $pdo->prepare('UPDATE users_profile_pics SET status_id = :active, user_updated = :uid WHERE id = :pic')
        ->execute([':active' => $activeStatusId, ':uid' => $this_user_id, ':pic' => $reactivatePicId]);
    $pdo->prepare('UPDATE users SET current_profile_pic_id = :pic, user_updated = :uid WHERE id = :user')
        ->execute([':pic' => $reactivatePicId, ':uid' => $this_user_id, ':user' => $id]);
    $pdo->commit();
    $_SESSION['message'] = 'Profile picture updated.';
  } catch (Exception $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    $_SESSION['message'] = 'Error updating profile picture.';
  }
  header('Location: ../edit.php?id=' . $id);
  exit;
}

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
$fileSize = $mime = $hashFile = null;
$width = $height = null;
$filename = null;

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
        $fileSize = $file['size'];
        $hashFile = hash_file('sha256', $dest);
        $img = getimagesize($dest);
        if ($img) {
          $width = $img[0];
          $height = $img[1];
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
    $stmt = $pdo->prepare('INSERT INTO users (user_id, user_updated, email, password, memo) VALUES (:uid, :uid, :email, :password, :memo)');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':email' => $email,
      ':password' => $hash,
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

  if ($profilePath) {
    $pdo->beginTransaction();
    $pdo->prepare('UPDATE users_profile_pics SET status_id = :inactive, user_updated = :uid WHERE user_id = :user AND status_id = :active')
        ->execute([':inactive' => $inactiveStatusId, ':uid' => $this_user_id, ':user' => $id, ':active' => $activeStatusId]);
    $pstmt = $pdo->prepare('INSERT INTO users_profile_pics (user_id, uploaded_by, file_name, file_path, file_size, file_type, width, height, file_hash, status_id, user_updated) VALUES (:user_id, :uploaded_by, :file_name, :file_path, :file_size, :file_type, :width, :height, :file_hash, :status_id, :uid)');
    $pstmt->execute([
      ':user_id' => $id,
      ':uploaded_by' => $this_user_id,
      ':file_name' => $filename,
      ':file_path' => $profilePath,
      ':file_size' => $fileSize,
      ':file_type' => $mime,
      ':width' => $width,
      ':height' => $height,
      ':file_hash' => $hashFile,
      ':status_id' => $activeStatusId,
      ':uid' => $this_user_id
    ]);
    $picId = (int)$pdo->lastInsertId();
    $pdo->prepare('UPDATE users SET current_profile_pic_id = :pic, user_updated = :uid WHERE id = :user')
        ->execute([':pic' => $picId, ':uid' => $this_user_id, ':user' => $id]);

    $pdo->commit();
  }

  $_SESSION['message'] = $isUpdate ? 'User updated.' : 'User created.';
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  $_SESSION['message'] = 'Error saving user.';
}

header('Location: ../index.php');
exit;
