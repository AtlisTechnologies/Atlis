<?php
require '../../includes/php_header.php';
require_permission('contractors','create');

$first = trim($_POST['first_name'] ?? '');
$last  = trim($_POST['last_name'] ?? '');
if($first !== '' && $last !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_contractors (user_id,user_updated,first_name,last_name) VALUES (:uid,:uid,:first,:last)');
  $stmt->execute([':uid'=>$this_user_id, ':first'=>$first, ':last'=>$last]);
  $id = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors',$id,'CREATE',null,json_encode(['first_name'=>$first,'last_name'=>$last]),'Created contractor');
  header('Location: ../contractor.php?id='.$id);
  exit;
}
header('Location: ../contractor.php');
exit;
