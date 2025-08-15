<?php
require '../../../includes/php_header.php';
require_permission('task', 'create');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $description = $_POST['description'] ?? null;
  $project_id = $_POST['project_id'] ?? null;
  $agency_id = $_POST['agency_id'] ?? null;
  $division_id = $_POST['division_id'] ?? null;

  // Default status to BACKLOG if not provided
  if (!$status) {
    foreach (get_lookup_items($pdo, 'TASK_STATUS') as $item) {
      if (strtoupper($item['code']) === 'BACKLOG') {
        $status = $item['id'];
        break;
      }
    }
  }

  $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, user_updated, project_id, agency_id, division_id, name, status, priority, description) VALUES (:uid, :uid, :project_id, :agency_id, :division_id, :name, :status, :priority, :description)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':project_id' => $project_id,
    ':agency_id' => $agency_id,
    ':division_id' => $division_id,
    ':name' => $name,
    ':status' => $status,
    ':priority' => $priority,
    ':description' => $description
  ]);
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_tasks', $id, 'CREATE', 'Created task');
}

$redirect = $_POST['redirect'] ?? '../index.php';
header('Location: ' . $redirect);
exit;

