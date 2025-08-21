<?php
require '../../../includes/php_header.php';
require_permission('contractors','delete');

$cid = (int)($_POST['contractor_id'] ?? 0);
$id  = (int)($_POST['id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#files');
  exit;
}

if($cid && $id){
  $stmt = $pdo->prepare('SELECT file_path FROM module_contractors_files WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':id'=>$id, ':cid'=>$cid]);
  $path = $stmt->fetchColumn();
  if($path){
    $full = dirname(__DIR__) . '/' . ltrim($path, '/');
    if(file_exists($full)){
      unlink($full);
    }
  }
  $stmt = $pdo->prepare('DELETE FROM module_contractors_files WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':id'=>$id, ':cid'=>$cid]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_files',$id,'DELETE','',null,'Deleted file');
  $msg = 'file-deleted';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#files' : '#files';
header('Location: '.$loc);
exit;
