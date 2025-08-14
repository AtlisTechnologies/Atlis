<?php
require '../../../includes/php_header.php';
require_permission('task', 'create');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $description = $_POST['description'] ?? null;

  $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, user_updated, name, status, priority, description) VALUES (:uid, :uid, :name, :status, :priority, :description)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':name' => $name,
    ':status' => $status,
    ':priority' => $priority,
    ':description' => $description
  ]);
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_tasks', $id, 'CREATE', 'Created task');
}

header('Location: ../index.php');
exit;

