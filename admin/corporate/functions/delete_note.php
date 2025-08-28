<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate_notes','delete');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if($id){
  $stmt = $pdo->prepare('DELETE FROM admin_corporate_notes WHERE id = :id');
  $stmt->execute([':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'admin_corporate_notes',$id,'DELETE','', '');
  echo json_encode(['success'=>true]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Unable to delete note']);
