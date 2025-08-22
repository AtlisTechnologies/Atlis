<?php
require '../../../includes/php_header.php';
$assignment_id = (int)($_POST['assignment_id'] ?? 0);
$agency_id = (int)($_POST['agency_id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';
require_permission('agency','update');
if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../agency_edit.php?id='.$agency_id);
  exit;
}
if($assignment_id){
  $stmt = $pdo->prepare('DELETE FROM module_agency_persons WHERE id=:id');
  $stmt->execute([':id'=>$assignment_id]);
  admin_audit_log($pdo,$this_user_id,'module_agency_persons',$assignment_id,'DELETE',null,null,'Removed person');
}
header('Location: ../agency_edit.php?id='.$agency_id.'#persons');
exit;
