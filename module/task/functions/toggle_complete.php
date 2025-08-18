<?php
require '../../../includes/php_header.php';
require_permission('task','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $completed = isset($_POST['completed']) ? (int)$_POST['completed'] : 0;
  $statusId = isset($_POST['status']) ? (int)$_POST['status'] : 0;
  if ($id > 0) {
    if ($completed === 1) {
      $statusStmt = $pdo->prepare("SELECT li.id, li.label, COALESCE(attr.attr_value, 'secondary') AS color_class FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS' WHERE l.name = 'TASK_STATUS' AND li.code = 'COMPLETED' LIMIT 1");
      $statusStmt->execute();
      $statusRow = $statusStmt->fetch(PDO::FETCH_ASSOC) ?: [];
      $statusId = (int)($statusRow['id'] ?? 0);
      $statusLabel = $statusRow['label'] ?? '';
      $statusColor = $statusRow['color_class'] ?? 'secondary';
      $stmt = $pdo->prepare('UPDATE module_tasks SET completed = 1, completed_by = :uid, complete_date = NOW(), progress_percent = 100, user_updated = :uid, status = :status WHERE id = :id');
    } else {
      if (!$statusId) {
        $origStmt = $pdo->prepare('SELECT status FROM module_tasks WHERE id = :id');
        $origStmt->execute([':id' => $id]);
        $statusId = (int)$origStmt->fetchColumn();
      }
      $statusStmt = $pdo->prepare("SELECT li.label, COALESCE(attr.attr_value, 'secondary') AS color_class FROM lookup_list_items li LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS' WHERE li.id = :id LIMIT 1");
      $statusStmt->execute([':id' => $statusId]);
      $statusRow = $statusStmt->fetch(PDO::FETCH_ASSOC) ?: [];
      $statusLabel = $statusRow['label'] ?? '';
      $statusColor = $statusRow['color_class'] ?? 'secondary';
      $stmt = $pdo->prepare('UPDATE module_tasks SET completed = 0, completed_by = NULL, complete_date = NULL, progress_percent = 0, user_updated = :uid, status = :status WHERE id = :id');
    }
    $stmt->execute([
      ':uid' => $this_user_id,
      ':id' => $id,
      ':status' => $statusId
    ]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', $completed ? 'Completed task' : 'Marked task incomplete');
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
    echo json_encode([
      'success'      => true,
      'completed'    => (int)$taskRow['completed'],
      'status_label' => $taskRow['status_label'],
      'status_color' => $taskRow['status_color']
    ]);
    exit;
  }
}

echo json_encode(['success' => false]);
