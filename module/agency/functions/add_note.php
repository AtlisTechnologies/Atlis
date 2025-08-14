<?php
require '../../../includes/php_header.php';
require_permission('agency','update');

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note'] ?? '');
if($id && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_agency_notes (user_id,user_updated,agency_id,note_text) VALUES (:uid,:uid,:aid,:note)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':aid' => $id,
    ':note' => $note
  ]);
  $noteId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_agency_notes',$noteId,'NOTE','', $note);
}
header('Location: ../details_view.php?id=' . $id);
exit;
