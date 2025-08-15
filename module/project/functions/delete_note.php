<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);

if ($id && $project_id) {
  $stmt = $pdo->prepare('SELECT user_id, note_text FROM module_projects_notes WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row && ($is_admin || $row['user_id'] == $this_user_id)) {
    $pdo->prepare('DELETE FROM module_projects_notes WHERE id = :id')->execute([':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'module_projects_notes', $id, 'DELETE', $row['note_text'], '');
  }
}

header('Location: ../details_view.php?id=' . $project_id);
exit;
