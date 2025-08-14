<?php
require '../../../includes/php_header.php';
require_permission('task','update');

$id = (int)($_POST['id'] ?? 0);
if($id && isset($_FILES['file'])){
  $file = $_FILES['file'];
  $uploadDir = '../uploads/';
  if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
  }
  $baseName = basename($file['name']);
  $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
  $targetName = 'task_' . $id . '_' . time() . '_' . $safeName;
  $targetPath = $uploadDir . $targetName;
  if(move_uploaded_file($file['tmp_name'],$targetPath)){
    $filePathDb = '/module/task/uploads/' . $targetName;
    $stmt = $pdo->prepare('INSERT INTO module_tasks_files (user_id,user_updated,task_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:tid,:name,:path,:size,:type)');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':tid' => $id,
      ':name' => $baseName,
      ':path' => $filePathDb,
      ':size' => $file['size'],
      ':type' => $file['type']
    ]);
    $fileId = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_tasks_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
  }
}
header('Location: ../details_view.php?id=' . $id);
exit;
