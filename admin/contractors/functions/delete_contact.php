<?php
require '../../../includes/php_header.php';
require_permission('contractors','delete');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$id   = (int)($_POST['id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#contacts');
  exit;
}

if($cid && $id){
  $stmt = $pdo->prepare('DELETE FROM module_contractors_contacts WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':id'=>$id, ':cid'=>$cid]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_contacts',$id,'DELETE','',null,'Deleted contact');
  $msg = 'contact-deleted';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#contacts' : '#contacts';
header('Location: '.$loc);
exit;
