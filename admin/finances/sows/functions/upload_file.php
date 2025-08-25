<?php
require '../../../../includes/php_header.php';
require_permission('sow','read');
require_permission('sow','update');

$sid = (int)($_POST['sow_id'] ?? 0);
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$description = trim($_POST['description'] ?? '');
$token = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '') || !$sid || !$file_type_id || !isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK){
  header('Location: ../edit.php?id='.$sid.'#files');
  exit;
}

$max = 10 * 1024 * 1024; //10MB
$allowedItems = get_lookup_items($pdo,'SOW_FILE_TYPE');
$allowed = array_map(fn($i)=>strtolower($i['code']), $allowedItems);
$file = $_FILES['file'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if(!in_array($ext,$allowed) || $file['size'] > $max){
  header('Location: ../edit.php?id='.$sid.'#files');
  exit;
}

$baseDir = dirname(__DIR__).'/uploads/'.$sid.'/';
if(!is_dir($baseDir)){
  mkdir($baseDir,0777,true);
}
$fileName = basename($file['name']);
$safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $fileName);
$targetPath = $baseDir.$safeName;
$relativePath = '/admin/finances/sows/uploads/'.$sid.'/'.$safeName;

$stmt = $pdo->prepare('SELECT id,file_path,version FROM module_sow_files WHERE sow_id=:sid AND file_name=:name ORDER BY version DESC LIMIT 1');
$stmt->execute([':sid'=>$sid,':name'=>$fileName]);
$prev = $stmt->fetch(PDO::FETCH_ASSOC);
$version = 1;
if($prev){
  $version = $prev['version'] + 1;
  $prevPath = $baseDir.basename($prev['file_path']);
  if(file_exists($prevPath)){
    $verDir = $baseDir.'versioned/';
    if(!is_dir($verDir)) mkdir($verDir,0777,true);
    rename($prevPath,$verDir.'v'.$prev['version'].'_'.basename($prevPath));
  }
}

if(move_uploaded_file($file['tmp_name'],$targetPath)){
  $pdo->prepare('INSERT INTO module_sow_files (user_id,user_updated,sow_id,file_type_id,file_name,file_path,version,description) VALUES (:uid,:uid,:sid,:ft,:name,:path,:ver,:desc)')->execute([
    ':uid'=>$this_user_id,
    ':sid'=>$sid,
    ':ft'=>$file_type_id,
    ':name'=>$fileName,
    ':path'=>$relativePath,
    ':ver'=>$version,
    ':desc'=>$description !== '' ? $description : null
  ]);
  $fid = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_sow_files',$fid,'UPLOAD',null,json_encode(['file'=>$fileName,'version'=>$version]));
}
header('Location: ../edit.php?id='.$sid.'#files');
exit;
