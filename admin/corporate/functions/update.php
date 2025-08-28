<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate','update');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
if($id && $name !== ''){
  $stmt = $pdo->prepare('UPDATE admin_corporate SET name = :name, description = :description, user_updated = :uid WHERE id = :id');
  $stmt->execute([
    ':name'=>$name,
    ':description'=>$description,
    ':uid'=>$this_user_id,
    ':id'=>$id
  ]);
  admin_audit_log($pdo,$this_user_id,'admin_corporate',$id,'UPDATE','',json_encode(['name'=>$name]));
  echo json_encode(['success'=>true]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Missing data']);
