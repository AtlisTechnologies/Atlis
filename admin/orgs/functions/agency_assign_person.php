<?php
require '../../../includes/php_header.php';
$agency_id = (int)($_POST['agency_id'] ?? 0);
$person_id = (int)($_POST['person_id'] ?? 0);
$role_id = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;
$is_lead = isset($_POST['is_lead']) ? 1 : 0;
$token = $_POST['csrf_token'] ?? '';
require_permission('agency','update');
if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../agency_edit.php?id='.$agency_id);
  exit;
}
if($agency_id && $person_id){
  if($is_lead){
    $pdo->prepare('UPDATE module_agency_persons SET is_lead=0 WHERE agency_id=:id')->execute([':id'=>$agency_id]);
  }
  $stmt = $pdo->prepare('INSERT INTO module_agency_persons (user_id,user_updated,agency_id,person_id,role_id,is_lead) VALUES (:uid,:uid,:aid,:pid,:role,:lead)');
  $stmt->execute([':uid'=>$this_user_id,':aid'=>$agency_id,':pid'=>$person_id,':role'=>$role_id,':lead'=>$is_lead]);
  $assignId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_agency_persons',$assignId,'CREATE',null,json_encode(['agency_id'=>$agency_id,'person_id'=>$person_id,'role_id'=>$role_id,'is_lead'=>$is_lead]),'Assigned person');
}
header('Location: ../agency_edit.php?id='.$agency_id.'#persons');
exit;
