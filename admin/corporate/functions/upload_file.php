<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate_files','create');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$cid = (int)($_POST['corporate_id'] ?? 0);
if($cid && !empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
  $uploadDir = __DIR__ . '/../uploads/';
  if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
  }
  $orig = $_FILES['file']['name'];
  $safe = preg_replace('/[^A-Za-z0-9._-]/','_', basename($orig));
  $targetName = 'corp_' . $cid . '_' . time() . '_' . $safe;
  $targetPath = $uploadDir . $targetName;
  if(move_uploaded_file($_FILES['file']['tmp_name'],$targetPath)){
    $dbPath = 'admin/corporate/uploads/' . $targetName;
    $stmt = $pdo->prepare('INSERT INTO admin_corporate_files (user_id,user_updated,corporate_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:cid,:name,:path,:size,:type)');
    $stmt->execute([
      ':uid'=>$this_user_id,
      ':cid'=>$cid,
      ':name'=>$orig,
      ':path'=>$dbPath,
      ':size'=>$_FILES['file']['size'],
      ':type'=>$_FILES['file']['type']
    ]);
    $fid = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'admin_corporate_files',$fid,'UPLOAD','',json_encode(['file'=>$orig]));
    echo json_encode(['success'=>true,'file'=>['id'=>$fid,'file_name'=>$orig,'file_path'=>getURLDir() . $dbPath]]);
    exit;
  }
}

echo json_encode(['success'=>false,'error'=>'Upload failed']);
