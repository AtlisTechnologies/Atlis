<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid = (int)($_POST['contractor_id'] ?? 0);
$nid = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note_text'] ?? '');

if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#notes');
  exit;
}

if($cid && $nid && $note !== ''){
  $stmtOld = $pdo->prepare('SELECT note_text FROM module_contractors_notes WHERE id=:id AND contractor_id=:cid');
  $stmtOld->execute([':id'=>$nid, ':cid'=>$cid]);
  $old = $stmtOld->fetchColumn();
  $stmt = $pdo->prepare('UPDATE module_contractors_notes SET note_text=:note, user_updated=:uid WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([':note'=>$note, ':uid'=>$this_user_id, ':id'=>$nid, ':cid'=>$cid]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_notes',$nid,'UPDATE',$old,$note,'Updated note');
  $msg = 'note-updated';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#notes' : '#notes';
header('Location: '.$loc);
exit;
