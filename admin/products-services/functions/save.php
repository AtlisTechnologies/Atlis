<?php
require '../../admin_header.php';

$token = $_POST['csrf_token'] ?? '';
if (!verify_csrf_token($token)) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name = trim($_POST['name'] ?? '');
$type_id = isset($_POST['type_id']) ? (int)$_POST['type_id'] : 0;
$status_id = isset($_POST['status_id']) ? (int)$_POST['status_id'] : 0;
$description = trim($_POST['description'] ?? '');
$price = isset($_POST['price']) && $_POST['price'] !== '' ? (float)$_POST['price'] : null;
$category_ids = isset($_POST['category_ids']) && is_array($_POST['category_ids']) ? array_map('intval', $_POST['category_ids']) : [];
$memo = trim($_POST['memo'] ?? '');
$assignments = isset($_POST['assignments']) && is_array($_POST['assignments']) ? $_POST['assignments'] : [];
$cleanAssignments = [];
foreach($assignments as $a){
  $pid = isset($a['person_id']) ? (int)$a['person_id'] : 0;
  $sid = isset($a['skill_id']) ? (int)$a['skill_id'] : 0;
  if($pid > 0 && $sid > 0){
    $cleanAssignments[] = ['person_id'=>$pid,'skill_id'=>$sid];
  }
}

require_permission('products_services', $id ? 'update' : 'create');

if ($name === '' || !$type_id || !$status_id) {
  header('Location: ../index.php');
  exit;
}

try{
  $pdo->beginTransaction();
  if ($id) {
    $stmtOld = $pdo->prepare('SELECT name, type_id, status_id, description, price, memo FROM module_products_services WHERE id=:id');
    $stmtOld->execute([':id'=>$id]);
    $old = $stmtOld->fetch(PDO::FETCH_ASSOC);
    $old_price = $old['price'];
    $stmt = $pdo->prepare('UPDATE module_products_services SET name=:name, type_id=:type_id, status_id=:status_id, description=:descr, price=:price, memo=:memo, user_updated=:uid WHERE id=:id');
    $stmt->execute([':name'=>$name, ':type_id'=>$type_id, ':status_id'=>$status_id, ':descr'=>$description, ':price'=>$price, ':memo'=>$memo, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo,$this_user_id,'module_products_services',$id,'UPDATE',json_encode($old),json_encode(['name'=>$name,'type_id'=>$type_id,'status_id'=>$status_id,'description'=>$description,'price'=>$price,'memo'=>$memo]),'Updated product/service');
    if($price !== $old_price){
      $ph = $pdo->prepare('INSERT INTO module_products_services_price_history (user_id,user_updated,product_service_id,old_price,new_price) VALUES (:uid,:uid,:psid,:old,:new)');
      $ph->execute([':uid'=>$this_user_id, ':psid'=>$id, ':old'=>$old_price, ':new'=>$price]);
    }
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_products_services (user_id,user_updated,name,type_id,status_id,description,price,memo) VALUES (:uid,:uid,:name,:type_id,:status_id,:descr,:price,:memo)');
    $stmt->execute([':uid'=>$this_user_id, ':name'=>$name, ':type_id'=>$type_id, ':status_id'=>$status_id, ':descr'=>$description, ':price'=>$price, ':memo'=>$memo]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_products_services',$id,'CREATE',null,json_encode(['name'=>$name,'type_id'=>$type_id,'status_id'=>$status_id,'description'=>$description,'price'=>$price,'memo'=>$memo]),'Created product/service');
    if($price !== null){
      $ph = $pdo->prepare('INSERT INTO module_products_services_price_history (user_id,user_updated,product_service_id,old_price,new_price) VALUES (:uid,:uid,:psid,NULL,:new)');
      $ph->execute([':uid'=>$this_user_id, ':psid'=>$id, ':new'=>$price]);
    }
  }

  $pdo->prepare('DELETE FROM module_products_services_category WHERE product_service_id=:id')->execute([':id'=>$id]);
  if($category_ids){
    $insCat = $pdo->prepare('INSERT INTO module_products_services_category (user_id,user_updated,product_service_id,category_id) VALUES (:uid,:uid,:psid,:cid)');
    foreach($category_ids as $cid){
      $insCat->execute([':uid'=>$this_user_id, ':psid'=>$id, ':cid'=>$cid]);
    }
  }

  $pdo->prepare('DELETE FROM module_products_services_person WHERE product_service_id=:id')->execute([':id'=>$id]);
  if($cleanAssignments){
    $ins = $pdo->prepare('INSERT INTO module_products_services_person (user_id,user_updated,product_service_id,person_id,skill_id) VALUES (:uid,:uid,:psid,:pid,:sid)');
    foreach($cleanAssignments as $a){
      $ins->execute([':uid'=>$this_user_id, ':psid'=>$id, ':pid'=>$a['person_id'], ':sid'=>$a['skill_id']]);
    }
  }
  $pdo->commit();
}catch(Exception $e){
  $pdo->rollBack();
  throw $e;
}

header('Location: ../edit.php?id='.$id.'&msg=saved');
exit;
