<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$contractor_id = (int)($_POST['contractor_id'] ?? 0);
$contact_id    = (int)($_POST['contact_id'] ?? 0);
$id            = (int)($_POST['id'] ?? 0);
$token         = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$contractor_id.'#contacts');
  exit;
}

if($contractor_id && $contact_id && $id){
  $stmt = $pdo->prepare('DELETE FROM module_contractors_contact_responses WHERE id=:id AND contact_id=:cid');
  $stmt->execute([':id'=>$id, ':cid'=>$contact_id]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_contact_responses',$id,'DELETE','',null,'Deleted contact response');
  $msg = 'response-deleted';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$contractor_id;
$loc .= $msg ? '&msg='.$msg.'#contacts' : '#contacts';
header('Location: '.$loc);
exit;
