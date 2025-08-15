<?php
require '../../../includes/php_header.php';
require_permission('task','update');

$task_id = (int)($_POST['task_id'] ?? 0);
$user_id = (int)($_POST['user_id'] ?? 0);

if ($task_id && $user_id) {
  $stmt = $pdo->prepare('SELECT user_id FROM module_tasks WHERE id = :id');
  $stmt->execute([':id' => $task_id]);
  $owner_id = $stmt->fetchColumn();
  if ($owner_id && ($is_admin || $owner_id == $this_user_id)) {
    $check = $pdo->prepare('SELECT id FROM module_task_assignments WHERE task_id = :tid AND assigned_user_id = :uid');
    $check->execute([':tid' => $task_id, ':uid' => $user_id]);
    if (!$check->fetchColumn()) {
      $ins = $pdo->prepare('INSERT INTO module_task_assignments (user_id,user_updated,task_id,assigned_user_id) VALUES (:uid,:uid,:tid,:aid)');
      $ins->execute([':uid' => $this_user_id, ':tid' => $task_id, ':aid' => $user_id]);
      $assignId = $pdo->lastInsertId();
      audit_log($pdo, $this_user_id, 'module_task_assignments', $assignId, 'ASSIGN', 'Assigned user');
    }
  }
}

header('Location: ../index.php?action=details&id=' . $task_id);
exit;
