<?php
require '../../../includes/php_header.php';
require_permission('task', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);

  if ($id) {
    $fields = [];
    $params = [
      ':uid' => $this_user_id,
      ':id' => $id
    ];

    if (array_key_exists('name', $_POST)) {
      $fields[] = 'name = :name';
      $params[':name'] = $_POST['name'];
    }
    if (array_key_exists('status', $_POST) && $_POST['status'] !== null && $_POST['status'] !== '') {
      $fields[] = 'status = :status';
      $params[':status'] = (int)$_POST['status'];
    }
    if (array_key_exists('priority', $_POST) && $_POST['priority'] !== null && $_POST['priority'] !== '') {
      $fields[] = 'priority = :priority';
      $params[':priority'] = (int)$_POST['priority'];
    }
    if (array_key_exists('description', $_POST)) {
      $fields[] = 'description = :description';
      $params[':description'] = $_POST['description'];
    }

    if ($fields) {
      $sql = 'UPDATE module_tasks SET ' . implode(', ', $fields) . ', user_updated = :uid WHERE id = :id';
      $stmt = $pdo->prepare($sql);
      $stmt->execute($params);
      audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Updated task');
    }

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
    $taskStmt->execute([':id' => $id]);
    $taskRow = $taskStmt->fetch(PDO::FETCH_ASSOC) ?: [];
    echo json_encode(['success' => true, 'task' => $taskRow]);
    exit;
  }
}

echo json_encode(['success' => false]);

