<?php
require '../../../includes/php_header.php';
require_permission('contractors','delete');

$cid = (int)($_POST['contractor_id'] ?? 0);
$nid = (int)($_POST['id'] ?? 0);

if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#notes');
  exit;
}

if($cid && $nid){
  $stmt = $pdo->prepare('DELETE FROM module_contractors_notes WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':id'=>$nid, ':cid'=>$cid]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_notes',$nid,'DELETE','',null,'Deleted note');
  $msg = 'note-deleted';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#notes' : '#notes';
header('Location: '.$loc);
exit;
