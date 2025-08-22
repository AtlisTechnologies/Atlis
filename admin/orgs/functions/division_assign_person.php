<?php
require '../../../includes/php_header.php';
$division_id = (int)($_POST['division_id'] ?? 0);
$person_id = (int)($_POST['person_id'] ?? 0);
$role_id = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;
$is_lead = isset($_POST['is_lead']) ? 1 : 0;
$token = $_POST['csrf_token'] ?? '';
require_permission('division','update');
if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../division_edit.php?id='.$division_id);
  exit;
}
if($division_id && $person_id){
  if($is_lead){
    $pdo->prepare('UPDATE module_division_persons SET is_lead=0 WHERE division_id=:id')->execute([':id'=>$division_id]);
  }
  $stmt = $pdo->prepare('INSERT INTO module_division_persons (user_id,user_updated,division_id,person_id,role_id,is_lead) VALUES (:uid,:uid,:did,:pid,:role,:lead)');
  $stmt->execute([':uid'=>$this_user_id,':did'=>$division_id,':pid'=>$person_id,':role'=>$role_id,':lead'=>$is_lead]);
  $assignId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_division_persons',$assignId,'CREATE',null,json_encode(['division_id'=>$division_id,'person_id'=>$person_id,'role_id'=>$role_id,'is_lead'=>$is_lead]),'Assigned person');
}
header('Location: ../division_edit.php?id='.$division_id.'#persons');
exit;
