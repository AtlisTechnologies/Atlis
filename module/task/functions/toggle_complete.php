<?php
require '../../../includes/php_header.php';
require_permission('task','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $completed = isset($_POST['completed']) ? (int)$_POST['completed'] : 0;
  if ($id > 0) {
    if ($completed === 1) {
      $stmt = $pdo->prepare('UPDATE module_tasks SET completed = 1, complete_date = NOW(), progress_percent = 100, user_updated = :uid WHERE id = :id');
    } else {
      $stmt = $pdo->prepare('UPDATE module_tasks SET completed = 0, complete_date = NULL, progress_percent = 0, user_updated = :uid WHERE id = :id');
    }
    $stmt->execute([
      ':uid' => $this_user_id,
      ':id' => $id
    ]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', $completed ? 'Completed task' : 'Marked task incomplete');
    echo json_encode(['success' => true, 'completed' => $completed]);
    exit;
  }
}

echo json_encode(['success' => false]);
