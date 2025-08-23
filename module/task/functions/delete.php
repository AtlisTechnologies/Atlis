<?php
require '../../../includes/php_header.php';
require_permission('task', 'delete');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id) {
    $chk = $pdo->prepare('SELECT t.id, p.user_id, p.is_private FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id = :id');
    $chk->execute([':id' => $id]);
    $task = $chk->fetch(PDO::FETCH_ASSOC);
    if (!$task || ($task['is_private'] && !user_has_role('Admin') && $task['user_id'] != $this_user_id)) {
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

