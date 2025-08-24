<?php
require '../../../includes/php_header.php';
require_permission('task','update');

$task_id = (int)($_POST['task_id'] ?? 0);
$user_id = (int)($_POST['user_id'] ?? 0);

if ($task_id && $user_id) {
  $sel = $pdo->prepare('SELECT id FROM module_task_assignments WHERE task_id = :tid AND assigned_user_id = :uid');
  $sel->execute([':tid' => $task_id, ':uid' => $user_id]);
  $assignId = $sel->fetchColumn();
  if ($assignId) {
    $del = $pdo->prepare('DELETE FROM module_task_assignments WHERE id = :id');
    $del->execute([':id' => $assignId]);
    audit_log($pdo, $this_user_id, 'module_task_assignments', $assignId, 'DELETE', 'Removed user assignment');
  }
}

header('Location: ../index.php?action=details&id=' . $task_id);
exit;
