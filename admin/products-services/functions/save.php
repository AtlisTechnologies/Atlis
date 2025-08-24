<?php
require '../../admin_header.php';

$token = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($token)) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$memo = trim($_POST['memo'] ?? '');
$persons = isset($_POST['persons']) && is_array($_POST['persons']) ? array_map('intval', $_POST['persons']) : [];

if ($name === '') {
  header('Location: ../index.php');
  exit;
}

if ($id) {
  require_permission('products_services','update');
  $stmtOld = $pdo->prepare('SELECT name, description, memo FROM module_products_services WHERE id=:id');
  $stmtOld->execute([':id'=>$id]);
  $old = $stmtOld->fetch(PDO::FETCH_ASSOC);
  $stmt = $pdo->prepare('UPDATE module_products_services SET name=:name, description=:descr, memo=:memo, user_updated=:uid WHERE id=:id');
  $stmt->execute([':name'=>$name, ':descr'=>$description, ':memo'=>$memo, ':uid'=>$this_user_id, ':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'module_products_services',$id,'UPDATE',json_encode($old),json_encode(['name'=>$name]),'Updated product/service');
} else {
  require_permission('products_services','create');
  $stmt = $pdo->prepare('INSERT INTO module_products_services (user_id,user_updated,name,description,memo) VALUES (:uid,:uid,:name,:descr,:memo)');
  $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':descr'=>$description, ':memo'=>$memo]);
  $id = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_products_services',$id,'CREATE',null,json_encode(['name'=>$name]),'Created product/service');
}

$pdo->prepare('DELETE FROM module_products_services_person WHERE product_service_id=:id')->execute([':id'=>$id]);
if($persons){
  $ins = $pdo->prepare('INSERT INTO module_products_services_person (user_id,user_updated,product_service_id,person_id) VALUES (:uid,:uid,:psid,:pid)');
  foreach($persons as $pid){
    if($pid>0){ $ins->execute([':uid'=>$this_user_id, ':psid'=>$id, ':pid'=>$pid]); }
  }
}

header('Location: ../edit.php?id='.$id.'&msg=saved');
exit;
