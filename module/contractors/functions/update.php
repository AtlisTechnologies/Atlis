<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$id    = (int)($_POST['id'] ?? 0);
$first = trim($_POST['first_name'] ?? '');
$last  = trim($_POST['last_name'] ?? '');
if($id && $first !== '' && $last !== ''){
  $stmtOld = $pdo->prepare('SELECT first_name,last_name FROM module_contractors WHERE id=:id');
  $stmtOld->execute([':id'=>$id]);
  $old = $stmtOld->fetch(PDO::FETCH_ASSOC);
  $stmt = $pdo->prepare('UPDATE module_contractors SET first_name=:first,last_name=:last,user_updated=:uid WHERE id=:id');
  $stmt->execute([':first'=>$first, ':last'=>$last, ':uid'=>$this_user_id, ':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'module_contractors',$id,'UPDATE',json_encode($old),json_encode(['first_name'=>$first,'last_name'=>$last]),'Updated contractor');
}
header('Location: ../../../admin/contractors/contractor.php?id='.$id);
exit;
