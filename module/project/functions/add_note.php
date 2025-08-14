<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note'] ?? '');
if($id && $note !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_projects_notes (user_id,user_updated,project_id,note_text) VALUES (:uid,:uid,:pid,:note)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':pid' => $id,
    ':note' => $note
  ]);
  $noteId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_projects_notes',$noteId,'NOTE','', $note);
}
header('Location: ../details_view.php?id=' . $id);
exit;
