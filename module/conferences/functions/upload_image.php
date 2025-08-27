<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$conference_id = (int)($_POST['conference_id'] ?? 0);
if ($conference_id && isset($_FILES['image'])) {
  $uploadDir = '../uploads/';
  if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
  $file = $_FILES['image'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $base = basename($file['name']);
    $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
    $target = 'conf_' . $conference_id . '_' . time() . '_' . $safe;
    $targetPath = $uploadDir . $target;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
      $path = '/module/conferences/uploads/' . $target;
      $stmt = $pdo->prepare('INSERT INTO module_conference_images (user_id, conference_id, file_name, file_path, file_size, file_type) VALUES (?,?,?,?,?,?)');
      $stmt->execute([$this_user_id, $conference_id, $base, $path, (int)$file['size'], $file['type']]);
      echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId(),'file_name'=>$base,'file_path'=>$path]);
      exit;
    }
  }
}
echo json_encode(['success'=>false]);
