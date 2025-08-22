<?php
require '../../../includes/php_header.php';
$assignment_id = (int)($_POST['assignment_id'] ?? 0);
$division_id = (int)($_POST['division_id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';
require_permission('division','update');
if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../division_edit.php?id='.$division_id);
  exit;
}
if($assignment_id){
  $stmt = $pdo->prepare('DELETE FROM module_division_persons WHERE id=:id');
  $stmt->execute([':id'=>$assignment_id]);
  admin_audit_log($pdo,$this_user_id,'module_division_persons',$assignment_id,'DELETE',null,null,'Removed person');
}
header('Location: ../division_edit.php?id='.$division_id.'#persons');
exit;
