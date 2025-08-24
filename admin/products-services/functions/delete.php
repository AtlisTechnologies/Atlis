<?php
require '../../admin_header.php';
require_permission('products_services','delete');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  header('Location: ../index.php');
  exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  die('Invalid CSRF token');
}

$id = (int)($_POST['id'] ?? 0);
if($id){
  $pdo->prepare('DELETE FROM module_products_services WHERE id=:id')->execute([':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'module_products_services',$id,'DELETE',null,null,'Deleted product/service');
}

header('Location: ../index.php?msg=deleted');
exit;
