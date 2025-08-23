<?php
require '../../../includes/php_header.php';
require_permission('task', 'delete');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id) {
    $chk = $pdo->prepare('SELECT t.id, t.user_id, t.project_id, t.is_private, p.user_id AS project_owner, p.is_private AS project_private FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id = :id');
    $chk->execute([':id' => $id]);
    $task = $chk->fetch(PDO::FETCH_ASSOC);
    if (!$task || (
        ($task['project_id'] && $task['project_private'] && !user_has_role('Admin') && $task['project_owner'] != $this_user_id) ||
        (!$task['project_id'] && $task['is_private'] && !user_has_role('Admin') && $task['user_id'] != $this_user_id)
      )) {
      http_response_code(403);
      header('Location: ../index.php');
      exit;
    }
    $stmt = $pdo->prepare('DELETE FROM module_tasks WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'DELETE', 'Deleted task');
  }
}

header('Location: ../index.php');
exit;

