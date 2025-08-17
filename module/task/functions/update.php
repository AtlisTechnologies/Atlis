<?php
require '../../../includes/php_header.php';
require_permission('task', 'update');

header('Content-Type: application/json');

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
    $taskStmt = $pdo->prepare(
      'SELECT t.id, t.name, t.status, t.priority, t.due_date, t.completed, ' .
      'ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color, ' .
      'lp.label AS priority_label, COALESCE(lpat.attr_value, "secondary") AS priority_color ' .
      'FROM module_tasks t ' .
      'LEFT JOIN lookup_list_items ls ON t.status = ls.id ' .
      'LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS" ' .
      'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
      'LEFT JOIN lookup_list_item_attributes lpat ON lp.id = lpat.item_id AND lpat.attr_code = "COLOR-CLASS" ' .
      'WHERE t.id = :id'
    );
    $taskStmt->execute([':id'=>$id]);
    $taskRow = $taskStmt->fetch(PDO::FETCH_ASSOC) ?: [];
    echo json_encode(['success'=>true,'task'=>$taskRow]);
    exit;
  }
}

echo json_encode(['success'=>false]);

