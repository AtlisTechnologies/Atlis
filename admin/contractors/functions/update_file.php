<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid = (int)($_POST['contractor_id'] ?? 0);
$id  = (int)($_POST['id'] ?? 0);
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$description = trim($_POST['description'] ?? '');
$token = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#files');
  exit;
}

if($cid && $id && $file_type_id){
  $stmt = $pdo->prepare('SELECT file_name,file_path,version FROM module_contractors_files WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':id'=>$id, ':cid'=>$cid]);
  $current = $stmt->fetch(PDO::FETCH_ASSOC);
  if($current){
    $fileName = $current['file_name'];
    $filePath = $current['file_path'];
    $version = (int)$current['version'];
    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
      $max = (int)get_system_property($pdo,'contractor_file_max_size');
      if(!$max){ $max = 10 * 1024 * 1024; }
      $allowedStr = get_system_property($pdo,'contractor_file_allowed_ext') ?: 'pdf,docx,jpg,png';
      $allowed = array_map('trim', explode(',', strtolower($allowedStr)));
      $file = $_FILES['file'];
      $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      if(in_array($ext,$allowed) && $file['size'] <= $max){
        $baseDir = dirname(__DIR__) . '/uploads/' . $cid . '/';
        if(!is_dir($baseDir)){ mkdir($baseDir,0777,true); }
        $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $fileName);
        $targetPath = $baseDir . $safeName;
        $relativePath = '/admin/contractors/uploads/'.$cid.'/'.$safeName;
        $verDir = $baseDir . 'versioned/';
        if(!is_dir($verDir)){ mkdir($verDir,0777,true); }
        $prevPath = $baseDir . basename($filePath);
        if(file_exists($prevPath)){
          rename($prevPath, $verDir . 'v'.$version.'_'.basename($prevPath));
        }
        if(move_uploaded_file($file['tmp_name'],$targetPath)){
          $version++;
          $filePath = $relativePath;
        }
      }
    }
    $stmt = $pdo->prepare('UPDATE module_contractors_files SET user_updated=:uid, file_type_id=:ftype, file_path=:path, version=:ver, description=:desc WHERE id=:id AND contractor_id=:cid');
    $stmt->execute([
      ':uid'=>$this_user_id,
      ':ftype'=>$file_type_id,
      ':path'=>$filePath,
      ':ver'=>$version,
      ':desc'=>$description !== '' ? $description : null,
      ':id'=>$id,
      ':cid'=>$cid
    ]);
    admin_audit_log($pdo,$this_user_id,'module_contractors_files',$id,'UPDATE','',json_encode(['file_name'=>$fileName,'version'=>$version]),'Updated file');
    $msg = 'file-updated';
  } else {
    $msg = null;
  }
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#files' : '#files';
header('Location: '.$loc);
exit;
