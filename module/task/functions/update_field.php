<?php
require '../../../includes/php_header.php';
require_permission('task','update');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$field = $_POST['field'] ?? '';
$value = (int)($_POST['value'] ?? 0);

if ($id > 0 && in_array($field, ['status','priority'], true)) {
  $chk = $pdo->prepare('SELECT t.id, t.user_id, t.project_id, t.is_private, p.user_id AS project_owner, p.is_private AS project_private FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id = :id');
  $chk->execute([':id' => $id]);
  $task = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$task || (
      ($task['project_id'] && $task['project_private'] && !user_has_role('Admin') && $task['project_owner'] != $this_user_id) ||
      (!$task['project_id'] && $task['is_private'] && !user_has_role('Admin') && $task['user_id'] != $this_user_id)
    )) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
  }
  $stmt = $pdo->prepare("UPDATE module_tasks SET {$field} = :value, user_updated = :uid WHERE id = :id");
  $stmt->execute([
    ':value' => $value,
    ':uid' => $this_user_id,
    ':id' => $id
  ]);
  audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Updated task ' . $field);

  $taskStmt = $pdo->prepare(
    'SELECT t.id, t.name, t.status, t.previous_status, t.priority, t.due_date, t.completed, ' .
    'ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color, ' .
    'lp.label AS priority_label, COALESCE(lpat.attr_value, "secondary") AS priority_color ' .
    'FROM module_tasks t ' .
    'LEFT JOIN lookup_list_items ls ON t.status = ls.id ' .
    'LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS" ' .
    'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
    'LEFT JOIN lookup_list_item_attributes lpat ON lp.id = lpat.item_id AND lpat.attr_code = "COLOR-CLASS" ' .
    'WHERE t.id = :id'
  );
  $taskStmt->execute([':id' => $id]);
  $taskRow = $taskStmt->fetch(PDO::FETCH_ASSOC) ?: [];

  echo json_encode(['success' => true, 'task' => $taskRow]);
  exit;
}

echo json_encode(['success' => false]);
