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
    $check = $pdo->prepare('SELECT id FROM module_projects_assignments WHERE project_id = :pid AND assigned_user_id = :uid');
    $check->execute([':pid' => $project_id, ':uid' => $user_id]);
    if (!$check->fetchColumn()) {
      $ins = $pdo->prepare('INSERT INTO module_projects_assignments (user_id,user_updated,project_id,assigned_user_id) VALUES (:uid,:uid,:pid,:aid)');
      $ins->execute([':uid' => $this_user_id, ':pid' => $project_id, ':aid' => $user_id]);
      $assignId = $pdo->lastInsertId();
      audit_log($pdo, $this_user_id, 'module_projects_assignments', $assignId, 'ASSIGN', 'Assigned user');
    }
  }
}

header('Location: ../details_view.php?id=' . $project_id);
exit;
