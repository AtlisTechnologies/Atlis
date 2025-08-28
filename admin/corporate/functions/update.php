<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
require_permission('admin_corporate', $id ? 'update' : 'create');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
if($name !== ''){
  if($id){
    $stmt = $pdo->prepare('UPDATE admin_corporate SET name = :name, description = :description, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':name'=>$name,
      ':description'=>$description,
      ':uid'=>$this_user_id,
      ':id'=>$id
    ]);
    admin_audit_log($pdo,$this_user_id,'admin_corporate',$id,'UPDATE','',json_encode(['name'=>$name]));
    echo json_encode(['success'=>true,'id'=>$id]);
    exit;
  } else {
    $stmt = $pdo->prepare('INSERT INTO admin_corporate (user_id,user_updated,name,description) VALUES (:uid,:uid,:name,:description)');
    $stmt->execute([
      ':uid'=>$this_user_id,
      ':name'=>$name,
      ':description'=>$description
    ]);
    $newId = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'admin_corporate',$newId,'CREATE','',json_encode(['name'=>$name]));
    echo json_encode(['success'=>true,'id'=>$newId]);
    exit;
  }
}

echo json_encode(['success'=>false,'error'=>'Missing data']);
