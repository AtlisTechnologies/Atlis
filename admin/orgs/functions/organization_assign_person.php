<?php
require '../../../includes/php_header.php';
$organization_id = (int)($_POST['organization_id'] ?? 0);
$person_id = (int)($_POST['person_id'] ?? 0);
$role_id = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;
$is_lead = isset($_POST['is_lead']) ? 1 : 0;
$token = $_POST['csrf_token'] ?? '';
require_permission('organization','update');
if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../organization_edit.php?id='.$organization_id);
  exit;
}
if($organization_id && $person_id){
  if($is_lead){
    $stmt = $pdo->prepare('UPDATE module_organization_persons SET is_lead=0 WHERE organization_id=:id');
    $stmt->execute([':id'=>$organization_id]);
  }
  $stmt = $pdo->prepare('INSERT INTO module_organization_persons (user_id,user_updated,organization_id,person_id,role_id,is_lead) VALUES (:uid,:uid,:org,:pid,:role,:lead)');
  $stmt->execute([':uid'=>$this_user_id,':org'=>$organization_id,':pid'=>$person_id,':role'=>$role_id,':lead'=>$is_lead]);
  $assignId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_organization_persons',$assignId,'CREATE',null,json_encode(['organization_id'=>$organization_id,'person_id'=>$person_id,'role_id'=>$role_id,'is_lead'=>$is_lead]),'Assigned person');
}
header('Location: ../organization_edit.php?id='.$organization_id.'#persons');
exit;
