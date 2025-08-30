<?php
require '../../../includes/php_header.php';
require_permission('task','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$id = (int)($_POST['id'] ?? 0);
$note_id = (int)($_POST['note_id'] ?? 0);
if($id && isset($_FILES['file'])){
  $allowed = [
    'pdf'  => 'application/pdf',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'png'  => 'image/png',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg'
  ];

  $maxMb = (int)get_system_property($pdo,'TASK_FILE_MAX_UPLOAD_MB');
  $maxSize = $maxMb ? $maxMb * 1024 * 1024 : 0;

  $uploadDir = dirname(__DIR__) . '/uploads/';
  if(!is_dir($uploadDir)){
    mkdir($uploadDir,0750,true);
  }
  $htaccessPath = $uploadDir . '.htaccess';
  if (!file_exists($htaccessPath)) {
    file_put_contents($htaccessPath,"php_flag engine off\n");
  }

  $file = $_FILES['file'];
  if($maxSize && $file['size'] > $maxSize){
    header('Location: ../index.php?action=details&id=' . $id . '&error=File too large');
    exit;
  }
  $baseName = basename($file['name']);
  $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
  $targetName = 'task_' . $id . '_' . time() . '_' . $safeName;
  $ext = strtolower(pathinfo($baseName, PATHINFO_EXTENSION));
  $mime = mime_content_type($file['tmp_name']);
  if (!isset($allowed[$ext]) || $allowed[$ext] !== $mime){
    header('Location: ../index.php?action=details&id=' . $id . '&error=Invalid file type');
    exit;
  }
  $targetPath = $uploadDir . $targetName;
  if(move_uploaded_file($file['tmp_name'],$targetPath)){
    chmod($targetPath,0640);
    $filePathDb = '/module/task/uploads/' . $targetName;
    $stmt = $pdo->prepare('INSERT INTO module_tasks_files (user_id,user_updated,task_id,note_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:tid,:nid,:name,:path,:size,:type)');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':tid' => $id,
      ':nid' => $note_id ?: null,
      ':name' => $baseName,
      ':path' => $filePathDb,
      ':size' => $file['size'],
      ':type' => $mime
    ]);
    $fileId = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_tasks_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
  }
}
header('Location: ../index.php?action=details&id=' . $id);
exit;
