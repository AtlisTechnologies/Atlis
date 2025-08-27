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
$feature_id = $_POST['feature_id'] !== '' ? (int)$_POST['feature_id'] : null;

if($id && $name !== ''){
  $stmt = $pdo->prepare('UPDATE module_corporate SET name = :name, description = :description, feature_id = :feature_id, user_updated = :uid WHERE id = :id');
  $stmt->execute([
    ':name'=>$name,
    ':description'=>$description,
    ':feature_id'=>$feature_id,
    ':uid'=>$this_user_id,
    ':id'=>$id
  ]);
  admin_audit_log($pdo,$this_user_id,'module_corporate',$id,'UPDATE','',json_encode(['name'=>$name]));
  echo json_encode(['success'=>true]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Missing data']);
