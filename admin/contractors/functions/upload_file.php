<?php
require '../../includes/php_header.php';

require_permission('contractors','update');

$cid = (int)($_POST['contractor_id'] ?? 0);
if($cid && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
  $max = (int)get_system_property($pdo,'contractor_file_max_size');
  if(!$max){ $max = 10 * 1024 * 1024; }
  $allowedStr = get_system_property($pdo,'contractor_file_allowed_ext') ?: 'pdf,docx,jpg,png';
  $allowed = array_map('trim', explode(',', strtolower($allowedStr)));
  $file = $_FILES['file'];
  $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
  if(!in_array($ext,$allowed) || $file['size'] > $max){
    header('Location: ../contractor.php?id='.$cid.'#files');
    exit;
  }
  $baseDir = dirname(__DIR__) . '/uploads/' . $cid . '/';
  if(!is_dir($baseDir)){ mkdir($baseDir,0777,true); }
  $fileName = basename($file['name']);
  $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $fileName);
  $targetPath = $baseDir . $safeName;
  $relativePath = '/admin/contractors/uploads/'.$cid.'/'.$safeName;
  $stmt = $pdo->prepare('SELECT id,file_path,version FROM module_contractors_files WHERE contractor_id=:cid AND file_name=:name ORDER BY version DESC LIMIT 1');
  $stmt->execute([':cid'=>$cid, ':name'=>$fileName]);
  $prev = $stmt->fetch(PDO::FETCH_ASSOC);
  $version = 1;
  if($prev){
    $version = $prev['version'] + 1;
    $prevPath = $baseDir . basename($prev['file_path']);
    if(file_exists($prevPath)){
      $verDir = $baseDir . 'versioned/v' . $prev['version'] . '/';
      if(!is_dir($verDir)){ mkdir($verDir,0777,true); }
      rename($prevPath, $verDir . basename($prevPath));
    }
  }
  if(move_uploaded_file($file['tmp_name'],$targetPath)){
    $stmt = $pdo->prepare('INSERT INTO module_contractors_files (user_id,user_updated,contractor_id,file_name,file_path,file_size,file_type,version) VALUES (:uid,:uid,:cid,:name,:path,:size,:type,:ver)');
    $stmt->execute([
      ':uid'=>$this_user_id,
      ':cid'=>$cid,
      ':name'=>$fileName,
      ':path'=>$relativePath,
      ':size'=>$file['size'],
      ':type'=>$file['type'],
      ':ver'=>$version
    ]);
    $fid = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_contractors_files',$fid,'UPLOAD','',json_encode(['file'=>$fileName,'version'=>$version]));
  }
}
header('Location: ../contractor.php?id='.$cid.'#files');
exit;
