<?php
require '../../../includes/php_header.php';
require_permission('project','update');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note'] ?? '');

if($id && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_projects_notes (user_id,user_updated,project_id,note_text) VALUES (:uid,:uid,:pid,:note)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':pid' => $id,
    ':note' => $note
  ]);
  $noteId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_projects_notes',$noteId,'NOTE','', $note);

  $uploaded = [];
  if(!empty($_FILES['files']) && is_array($_FILES['files']['name'])){
    $files = $_FILES['files'];
    $uploadDir = '../uploads/';
    if(!is_dir($uploadDir)){
      mkdir($uploadDir,0777,true);
    }
    foreach($files['name'] as $i => $fname){
      if($files['error'][$i] === UPLOAD_ERR_OK && $files['size'][$i] > 0){
        $baseName = basename($fname);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
        $targetName = 'project_' . $id . '_' . time() . '_' . $i . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if(move_uploaded_file($files['tmp_name'][$i], $targetPath)){
          $filePathDb = '/module/project/uploads/' . $targetName;
          $stmt = $pdo->prepare('INSERT INTO module_projects_files (user_id,user_updated,project_id,note_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:pid,:nid,:name,:path,:size,:type)');
          $stmt->execute([
            ':uid' => $this_user_id,
            ':pid' => $id,
            ':nid' => $noteId,
            ':name' => $baseName,
            ':path' => $filePathDb,
            ':size' => $files['size'][$i],
            ':type' => $files['type'][$i]
          ]);
          $fileId = $pdo->lastInsertId();
          $uploaded[] = [
            'id' => $fileId,
            'file_name' => $baseName,
            'file_path' => $filePathDb,
            'file_size' => $files['size'][$i],
            'file_type' => $files['type'][$i]
          ];
          admin_audit_log($pdo,$this_user_id,'module_projects_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
        }
      }
    }
  }

  $noteStmt = $pdo->prepare('SELECT n.id, n.user_id, n.note_text, n.date_created, upp.file_path, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id AND upp.is_active = 1 LEFT JOIN person p ON u.id = p.user_id WHERE n.id = :id');
  $noteStmt->execute([':id' => $noteId]);
  $noteRow = $noteStmt->fetch(PDO::FETCH_ASSOC) ?: [];
  $noteRow['files'] = $uploaded;

  echo json_encode(['success'=>true,'note'=>$noteRow]);
  exit;
}

echo json_encode(['success'=>false]);
