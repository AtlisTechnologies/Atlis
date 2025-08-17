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
    echo json_encode(['success' => true, 'completed' => $completed, 'status_label' => $statusLabel ?? '', 'status_color' => $statusColor ?? 'secondary']);
    exit;
  }
}

echo json_encode(['success' => false]);
