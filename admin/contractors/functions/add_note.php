<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$note = trim($_POST['note_text'] ?? '');
if($cid && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_contractors_notes (user_id,user_updated,contractor_id,note_text) VALUES (:uid,:uid,:cid,:note)');
  $stmt->execute([':uid'=>$this_user_id, ':cid'=>$cid, ':note'=>$note]);
  $nid = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_notes',$nid,'NOTE','', $note);
}
header('Location: ../contractor.php?id='.$cid.'#notes');
exit;
