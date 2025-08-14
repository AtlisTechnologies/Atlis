<?php
require '../../../includes/php_header.php';
require_permission('task', 'update');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $description = $_POST['description'] ?? null;

  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_tasks SET name = :name, status = :status, priority = :priority, description = :description, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':name' => $name,
      ':status' => $status,
      ':priority' => $priority,
      ':description' => $description,
      ':id' => $id
    ]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Updated task');
  }
}

header('Location: ../index.php');
exit;

