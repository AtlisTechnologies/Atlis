<?php
require '../../../includes/php_header.php';
require_permission('admin_corporate_notes','create');
header('Content-Type: application/json');

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$cid = (int)($_POST['corporate_id'] ?? 0);
$note = trim($_POST['note_text'] ?? '');

if($cid && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO admin_corporate_notes (user_id,user_updated,corporate_id,note_text) VALUES (:uid,:uid,:cid,:note)');
  $stmt->execute([':uid'=>$this_user_id, ':cid'=>$cid, ':note'=>$note]);
  $nid = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'admin_corporate_notes',$nid,'NOTE','', $note);
  echo json_encode(['success'=>true,'note'=>['id'=>$nid,'note_text'=>$note]]);
  exit;
}

echo json_encode(['success'=>false,'error'=>'Unable to add note']);
