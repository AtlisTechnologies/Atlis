<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
  $meeting_id = (int)($_POST['meeting_id'] ?? 0);
  $file = $_FILES['file'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    $safeName = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\.\-_]/', '_', $file['name']);
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $safeName)) {
      $path = 'uploads/' . $safeName;
      $stmt = $pdo->prepare('INSERT INTO module_meeting_files (user_id, user_updated, meeting_id, file_name, file_path) VALUES (?,?,?,?,?)');
      $stmt->execute([$this_user_id, $this_user_id, $meeting_id, $file['name'], $path]);
      $id = $pdo->lastInsertId();
      audit_log($pdo, $this_user_id, 'module_meeting_files', $id, 'CREATE', 'Uploaded file');
      echo json_encode(['success'=>true,'file'=>['id'=>$id,'file_name'=>$file['name'],'file_path'=>$path]]);
      exit;
    }
  }
}

echo json_encode(['success'=>false]);
