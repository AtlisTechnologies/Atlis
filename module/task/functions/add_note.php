<?php
require '../../../includes/php_header.php';
require_permission('task','update');

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note'] ?? '');
if($id && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_tasks_notes (user_id,user_updated,task_id,note_text) VALUES (:uid,:uid,:tid,:note)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':tid' => $id,
    ':note' => $note
  ]);
  $noteId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_tasks_notes',$noteId,'NOTE','', $note);

  if(isset($_FILES['files'])){
    $uploadDir = '../uploads/';
    if(!is_dir($uploadDir)){
      mkdir($uploadDir,0777,true);
    }
    foreach($_FILES['files']['name'] as $idx => $name){
      if($_FILES['files']['error'][$idx] === UPLOAD_ERR_OK){
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
        $targetName = 'task_' . $id . '_' . time() . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if(move_uploaded_file($_FILES['files']['tmp_name'][$idx], $targetPath)){
          $filePathDb = '/module/task/uploads/' . $targetName;
          $stmtFile = $pdo->prepare('INSERT INTO module_tasks_files (user_id,user_updated,task_id,note_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:tid,:nid,:name,:path,:size,:type)');
          $stmtFile->execute([
            ':uid' => $this_user_id,
            ':tid' => $id,
            ':nid' => $noteId,
            ':name' => $baseName,
            ':path' => $filePathDb,
            ':size' => $_FILES['files']['size'][$idx],
            ':type' => $_FILES['files']['type'][$idx]
          ]);
          $fileId = $pdo->lastInsertId();
          admin_audit_log($pdo,$this_user_id,'module_tasks_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
        }
      }
    }
  }
}
header('Location: ../index.php?action=details&id=' . $id);
exit;
