<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate_files','delete');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if($id){
  $stmt = $pdo->prepare('SELECT file_path FROM admin_corporate_files WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  $path = $stmt->fetchColumn();
  if($path){
    $full = __DIR__ . '/../../' . $path;
    if(file_exists($full)){
      unlink($full);
    }
  }
  $pdo->prepare('DELETE FROM admin_corporate_files WHERE id = :id')->execute([':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'admin_corporate_files',$id,'DELETE','', '');
  echo json_encode(['success'=>true]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Unable to delete file']);
