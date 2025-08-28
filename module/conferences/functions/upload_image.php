<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$conference_id = (int)($_POST['conference_id'] ?? 0);
$is_banner = !empty($_POST['is_banner']) ? 1 : 0;
$fileField = $_FILES['image'] ?? ($_FILES['file'] ?? null);
if ($conference_id && $fileField) {
  $uploadDir = '../uploads/';
  if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
  $file = $fileField;
  if ($file['error'] === UPLOAD_ERR_OK) {
    $base = basename($file['name']);
    $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
    $target = 'conf_' . $conference_id . '_' . time() . '_' . $safe;
    $targetPath = $uploadDir . $target;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
      $path = '/module/conferences/uploads/' . $target;
      $stmt = $pdo->prepare('INSERT INTO module_conference_images (user_id, conference_id, file_name, file_path, file_size, file_type, is_banner) VALUES (?,?,?,?,?,?,?)');
      $stmt->execute([$this_user_id, $conference_id, $base, $path, (int)$file['size'], $file['type'], $is_banner]);
      $imgId = $pdo->lastInsertId();
      if ($is_banner) {
        $pdo->prepare('UPDATE module_conferences SET banner_image_id=? WHERE id=?')->execute([$imgId, $conference_id]);
      }
      echo json_encode(['success'=>true,'id'=>$imgId,'file_name'=>$base,'file_path'=>$path]);
      exit;
    }
  }
}
echo json_encode(['success'=>false]);
