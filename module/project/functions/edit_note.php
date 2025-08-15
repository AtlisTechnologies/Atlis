<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);
$note = trim($_POST['note'] ?? '');

if ($id && $project_id && $note !== '') {
  $stmt = $pdo->prepare('SELECT user_id, note_text FROM module_projects_notes WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row && ($is_admin || $row['user_id'] == $this_user_id)) {
    $upd = $pdo->prepare('UPDATE module_projects_notes SET note_text = :note, user_updated = :uid WHERE id = :id');
    $upd->execute([':note' => $note, ':uid' => $this_user_id, ':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'module_projects_notes', $id, 'UPDATE', $row['note_text'], $note);
  }
}

header('Location: ../details_view.php?id=' . $project_id);
exit;
