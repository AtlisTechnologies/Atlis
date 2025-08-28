<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate','update');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$text = trim($_POST['note_text'] ?? '');

if($id && $text !== ''){
  $stmt = $pdo->prepare('UPDATE admin_corporate_notes SET note_text = :text, user_updated = :uid WHERE id = :id');
  $stmt->execute([':text'=>$text, ':uid'=>$this_user_id, ':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'admin_corporate_notes',$id,'UPDATE','',$text);
  echo json_encode(['success'=>true]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Unable to edit note']);
