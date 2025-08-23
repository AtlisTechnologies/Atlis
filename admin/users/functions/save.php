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
$gender_id = isset($_POST['gender_id']) && $_POST['gender_id'] !== '' ? (int)$_POST['gender_id'] : null;
$organization_id = isset($_POST['organization_id']) && $_POST['organization_id'] !== '' ? (int)$_POST['organization_id'] : null;
$agency_id = isset($_POST['agency_id']) && $_POST['agency_id'] !== '' ? (int)$_POST['agency_id'] : null;
$division_id = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? (int)$_POST['division_id'] : null;
$dob = $_POST['dob'] ?? '';

function get_status_id(PDO $pdo, string $code): int {
  $stmt = $pdo->prepare("SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_PROFILE_PIC_STATUS' AND li.code = :code LIMIT 1");
  $stmt->execute([':code' => $code]);
  return (int)$stmt->fetchColumn();
}

$activeStatusId = get_status_id($pdo, 'ACTIVE');
$inactiveStatusId = get_status_id($pdo, 'INACTIVE');
if (!$activeStatusId || !$inactiveStatusId) {
  $_SESSION['error_message'] = 'Profile picture status values not configured.';
  $_SESSION['message'] = 'Error updating profile picture.';
  header('Location: ../index.php');
  exit;
}

if ($reactivatePicId && $id) {
  try {
    $pdo->beginTransaction();

    if ($gender_id !== null || $dob !== '') {
      $personParams = [
        ':uid_fk' => $id,
        ':gender_id' => $gender_id,
        ':organization_id' => $organization_id,
        ':agency_id' => $agency_id,
        ':division_id' => $division_id,
        ':dob' => $dob ?: null,
        ':uid_update' => $this_user_id
      ];
      $pdo->prepare(
        'INSERT INTO person (user_id, gender_id, organization_id, agency_id, division_id, dob, user_updated)
         VALUES (:uid_fk, :gender_id, :organization_id, :agency_id, :division_id, :dob, :uid_update)
         ON DUPLICATE KEY UPDATE
           gender_id = VALUES(gender_id),
           organization_id = VALUES(organization_id),
           agency_id = VALUES(agency_id),
           division_id = VALUES(division_id),
           dob = VALUES(dob),
           user_updated = VALUES(user_updated)'
      )->execute($personParams);
    }

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
    error_log($e->getMessage());
    $_SESSION['error_message'] = substr($e->getMessage(), 0, 200);
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
$memo = $_POST['memo'] ?? null;
$addresses = $_POST['addresses'] ?? [];
$phones    = $_POST['phones'] ?? [];

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
    $typeItems = get_lookup_items($pdo, 'IMAGE_FILE_TYPES');
    $allowed   = array_column($typeItems, 'code');
    $extMap    = array_column($typeItems, 'label', 'code');
    if (!in_array($mime, $allowed, true)) {
      $_SESSION['error_message'] = 'Unsupported image type.';
      $_SESSION['message'] = 'Error uploading profile picture.';
      header('Location: ../edit.php?id=' . $id);
      exit;
    }
    $ext = $extMap[$mime] ?? pathinfo($file['name'], PATHINFO_EXTENSION);
    $safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
    $filename = $safe . '_' . time() . '.' . $ext;
    $destDir = '../../../module/users/uploads/';
    if (!is_dir($destDir)) {
      mkdir($destDir, 0755, true);
    }
    $dest = $destDir . $filename;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
      $_SESSION['error_message'] = 'Failed to move uploaded file.';
      $_SESSION['message'] = 'Error uploading profile picture.';
      header('Location: ../edit.php?id=' . $id);
      exit;
    }
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

try {
  $pdo->beginTransaction();
  $person_id = 0;
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

    $personStmt = $pdo->prepare('SELECT * FROM person WHERE user_id = :uid_fk');
    $personStmt->execute([':uid_fk' => $id]);
    $existingPerson = $personStmt->fetch(PDO::FETCH_ASSOC);
    $personData = [
      ':uid_fk' => $id,
      ':fn' => $first_name,
      ':ln' => $last_name,
      ':gender_id' => $gender_id,
      ':organization_id' => $organization_id,
      ':agency_id' => $agency_id,
      ':division_id' => $division_id,
      ':dob' => $dob ?: null,
      ':uid_update' => $this_user_id
    ];
    if ($existingPerson) {
      $person_id = (int)$existingPerson['id'];
      $personData[':pid'] = $person_id;
      $pstmt = $pdo->prepare('UPDATE person SET first_name = :fn, last_name = :ln, gender_id = :gender_id, organization_id = :organization_id, agency_id = :agency_id, division_id = :division_id, dob = :dob, user_updated = :uid_update WHERE id = :pid');
      $pstmt->execute($personData);
      admin_audit_log($pdo,$this_user_id,'person',$person_id,'UPDATE',json_encode($existingPerson),json_encode(['first_name'=>$first_name,'last_name'=>$last_name,'gender_id'=>$gender_id,'organization_id'=>$organization_id,'agency_id'=>$agency_id,'division_id'=>$division_id,'dob'=>$dob ?: null]),'Updated person');
    } else {
      $pstmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, gender_id, organization_id, agency_id, division_id, dob, user_updated) VALUES (:uid_fk, :fn, :ln, :gender_id, :organization_id, :agency_id, :division_id, :dob, :uid_update)');
      $pstmt->execute($personData);
      $person_id = (int)$pdo->lastInsertId();
      admin_audit_log($pdo,$this_user_id,'person',$person_id,'CREATE',null,json_encode(['user_id'=>$id,'first_name'=>$first_name,'last_name'=>$last_name,'gender_id'=>$gender_id,'organization_id'=>$organization_id,'agency_id'=>$agency_id,'division_id'=>$division_id,'dob'=>$dob ?: null]),'Created person');
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

    $personData = [
      ':uid_fk' => $id,
      ':fn' => $first_name,
      ':ln' => $last_name,
      ':gender_id' => $gender_id,
      ':organization_id' => $organization_id,
      ':agency_id' => $agency_id,
      ':division_id' => $division_id,
      ':dob' => $dob ?: null,
      ':uid_update' => $this_user_id
    ];
    $pstmt = $pdo->prepare('INSERT INTO person (user_id, first_name, last_name, gender_id, organization_id, agency_id, division_id, dob, user_updated) VALUES (:uid_fk, :fn, :ln, :gender_id, :organization_id, :agency_id, :division_id, :dob, :uid_update)');
    $pstmt->execute($personData);
    $person_id = (int)$pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'person',$person_id,'CREATE',null,json_encode(['user_id'=>$id,'first_name'=>$first_name,'last_name'=>$last_name,'gender_id'=>$gender_id,'organization_id'=>$organization_id,'agency_id'=>$agency_id,'division_id'=>$division_id,'dob'=>$dob ?: null]),'Created person');
  }

  $stmt = $pdo->prepare('SELECT id FROM person_addresses WHERE person_id = :id');
  $stmt->execute([':id'=>$person_id]);
  $existingAddrIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $submittedAddrIds = [];
  foreach ($addresses as $addr) {
    $addrId = !empty($addr['id']) ? (int)$addr['id'] : 0;
    $line1 = trim($addr['address_line1'] ?? '');
    if ($line1 === '') {
      continue;
    }
    $data = [
      ':pid'      => $person_id,
      ':type_id'  => $addr['type_id'] !== '' ? (int)$addr['type_id'] : null,
      ':status_id'=> $addr['status_id'] !== '' ? (int)$addr['status_id'] : null,
      ':start_date'=> $addr['start_date'] !== '' ? $addr['start_date'] : null,
      ':end_date'  => $addr['end_date'] !== '' ? $addr['end_date'] : null,
      ':line1'     => $line1,
      ':line2'     => trim($addr['address_line2'] ?? ''),
      ':city'      => trim($addr['city'] ?? ''),
      ':state_id'  => $addr['state_id'] !== '' ? (int)$addr['state_id'] : null,
      ':postal'    => trim($addr['postal_code'] ?? ''),
      ':country'   => trim($addr['country'] ?? ''),
      ':uid'       => $this_user_id
    ];
    if ($addrId) {
      $data[':id'] = $addrId;
      $stmt = $pdo->prepare('UPDATE person_addresses SET type_id=:type_id,status_id=:status_id,start_date=:start_date,end_date=:end_date,address_line1=:line1,address_line2=:line2,city=:city,state_id=:state_id,postal_code=:postal,country=:country,user_updated=:uid WHERE id=:id AND person_id=:pid');
      $stmt->execute($data);
      admin_audit_log($pdo,$this_user_id,'person_addresses',$addrId,'UPDATE',null,json_encode($data),'Updated address');
      $submittedAddrIds[] = $addrId;
    } else {
      $stmt = $pdo->prepare('INSERT INTO person_addresses (person_id,type_id,status_id,start_date,end_date,address_line1,address_line2,city,state_id,postal_code,country,user_id,user_updated) VALUES (:pid,:type_id,:status_id,:start_date,:end_date,:line1,:line2,:city,:state_id,:postal,:country,:uid,:uid)');
      $stmt->execute($data);
      $newId = $pdo->lastInsertId();
      admin_audit_log($pdo,$this_user_id,'person_addresses',$newId,'CREATE',null,json_encode($data),'Added address');
      $submittedAddrIds[] = $newId;
    }
  }
  foreach ($existingAddrIds as $eid) {
    if (!in_array($eid,$submittedAddrIds)) {
      $stmt = $pdo->prepare('DELETE FROM person_addresses WHERE id=:id');
      $stmt->execute([':id'=>$eid]);
      admin_audit_log($pdo,$this_user_id,'person_addresses',$eid,'DELETE',null,null,'Deleted address');
    }
  }

  $stmt = $pdo->prepare('SELECT id FROM person_phones WHERE person_id = :id');
  $stmt->execute([':id'=>$person_id]);
  $existingPhoneIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $submittedPhoneIds = [];
  foreach ($phones as $ph) {
    $phId = !empty($ph['id']) ? (int)$ph['id'] : 0;
    $number = trim($ph['phone_number'] ?? '');
    if ($number === '') {
      continue;
    }
    $data = [
      ':pid'       => $person_id,
      ':type_id'   => $ph['type_id'] !== '' ? (int)$ph['type_id'] : null,
      ':status_id' => $ph['status_id'] !== '' ? (int)$ph['status_id'] : null,
      ':start_date'=> $ph['start_date'] !== '' ? $ph['start_date'] : null,
      ':end_date'  => $ph['end_date'] !== '' ? $ph['end_date'] : null,
      ':number'    => $number,
      ':uid'       => $this_user_id
    ];
    if ($phId) {
      $data[':id'] = $phId;
      $stmt = $pdo->prepare('UPDATE person_phones SET type_id=:type_id,status_id=:status_id,start_date=:start_date,end_date=:end_date,phone_number=:number,user_updated=:uid WHERE id=:id AND person_id=:pid');
      $stmt->execute($data);
      admin_audit_log($pdo,$this_user_id,'person_phones',$phId,'UPDATE',null,json_encode($data),'Updated phone');
      $submittedPhoneIds[] = $phId;
    } else {
      $stmt = $pdo->prepare('INSERT INTO person_phones (person_id,type_id,status_id,start_date,end_date,phone_number,user_id,user_updated) VALUES (:pid,:type_id,:status_id,:start_date,:end_date,:number,:uid,:uid)');
      $stmt->execute($data);
      $newId = $pdo->lastInsertId();
      admin_audit_log($pdo,$this_user_id,'person_phones',$newId,'CREATE',null,json_encode($data),'Added phone');
      $submittedPhoneIds[] = $newId;
    }
  }
  foreach ($existingPhoneIds as $eid) {
    if (!in_array($eid,$submittedPhoneIds)) {
      $stmt = $pdo->prepare('DELETE FROM person_phones WHERE id=:id');
      $stmt->execute([':id'=>$eid]);
      admin_audit_log($pdo,$this_user_id,'person_phones',$eid,'DELETE',null,null,'Deleted phone');
    }
  }

  // Refresh contractor contact info if applicable
  if($person_id){
    update_contractor_contact($pdo, $person_id);
  }

  if ($profilePath) {
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
  }

  $pdo->commit();

  $_SESSION['message'] = $isUpdate ? 'User updated.' : 'User created.';
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  error_log($e->getMessage());
  $_SESSION['error_message'] = substr($e->getMessage(), 0, 200);
  $_SESSION['message'] = 'Error saving user.';
}
// Redirect differently if updating and a new profile picture was uploaded
if ($isUpdate && $profilePath) {
  header('Location: ../edit.php?id=' . $id);
  exit;
}

header('Location: ../index.php');
exit;
