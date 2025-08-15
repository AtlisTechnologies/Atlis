<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
$user_id = (int)($_POST['user_id'] ?? 0);

if ($project_id && $user_id) {
  $stmt = $pdo->prepare('SELECT user_id FROM module_projects WHERE id = :id');
  $stmt->execute([':id' => $project_id]);
  $owner_id = $stmt->fetchColumn();
  if ($owner_id && ($is_admin || $owner_id == $this_user_id)) {
    $sel = $pdo->prepare('SELECT id FROM module_projects_assignments WHERE project_id = :pid AND assigned_user_id = :uid');
    $sel->execute([':pid' => $project_id, ':uid' => $user_id]);
    $assignId = $sel->fetchColumn();
    if ($assignId) {
      $del = $pdo->prepare('DELETE FROM module_projects_assignments WHERE id = :id');
      $del->execute([':id' => $assignId]);
      audit_log($pdo, $this_user_id, 'module_projects_assignments', $assignId, 'DELETE', 'Removed user assignment');
    }
  }
}

header('Location: ../index.php?action=details&id=' . $project_id);
exit;
