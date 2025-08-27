<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$id = (int)($_POST['id'] ?? 0);
if ($id && isset($_FILES['image'])) {
  $uploadDir = '../uploads/';
  if (!is_dir($uploadDir)) { mkdir($uploadDir,0777,true); }
  $file = $_FILES['image'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $base = basename($file['name']);
    $safe = preg_replace('/[^A-Za-z0-9._-]/','_', $base);
    $target = 'conf_' . $id . '_' . time() . '_' . $safe;
    $targetPath = $uploadDir . $target;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
      $path = '/module/conferences/uploads/' . $target;
      $stmt = $pdo->prepare('SELECT images FROM module_conferences WHERE id=?');
      $stmt->execute([$id]);
      $imgs = $stmt->fetchColumn();
      $imgArr = $imgs ? json_decode($imgs, true) : [];
      $imgArr[] = $path;
      $pdo->prepare('UPDATE module_conferences SET images=? WHERE id=?')->execute([json_encode($imgArr),$id]);
    }
  }
}
header('Location: ../index.php?action=details&id=' . $id);
exit;
