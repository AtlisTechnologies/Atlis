<?php
require '../../../includes/php_header.php';
require_permission('task', 'create');

$isAjax = isset($_POST['ajax']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
if($isAjax){
  header('Content-Type: application/json');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  if ($name === '') {
    $name = 'Task ' . bin2hex(random_bytes(2));
  }
  $status = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $description = $_POST['description'] ?? null;
  $project_id = $_POST['project_id'] ?? null;
  $agency_id = isset($_POST['agency_id']) && $_POST['agency_id'] !== '' ? $_POST['agency_id'] : null;
  $division_id = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? $_POST['division_id'] : null;

  if ($project_id) {
    $pstmt = $pdo->prepare('SELECT user_id, is_private FROM module_projects WHERE id = :pid');
    $pstmt->execute([':pid' => $project_id]);
    $proj = $pstmt->fetch(PDO::FETCH_ASSOC);
    if ($proj && $proj['is_private'] && !user_has_role('Admin') && $proj['user_id'] != $this_user_id) {
      http_response_code(403);
      if ($isAjax) {
        echo json_encode(['success' => false]);
      } else {
        header('Location: ../index.php');
      }
      exit;
    }
  }

  // Default status to BACKLOG if not provided
  if (!$status) {
    foreach (get_lookup_items($pdo, 'TASK_STATUS') as $item) {
      if (strtoupper($item['code']) === 'BACKLOG') {
        $status = $item['id'];
        break;
      }
    }
  }

  // Default priority if not provided
  if (!$priority) {
    foreach (get_lookup_items($pdo, 'TASK_PRIORITY') as $item) {
      if (!empty($item['is_default'])) {
        $priority = $item['id'];
        break;
      }
    }
  }

  $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, user_updated, project_id, agency_id, division_id, name, status, priority, description) VALUES (:uid, :uid, :project_id, :agency_id, :division_id, :name, :status, :priority, :description)');
  $stmt->bindValue(':uid', $this_user_id, PDO::PARAM_INT);
  $stmt->bindValue(':project_id', $project_id);
  $stmt->bindValue(':agency_id', $agency_id, $agency_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
  $stmt->bindValue(':division_id', $division_id, $division_id !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':status', $status);
  $stmt->bindValue(':priority', $priority);
  $stmt->bindValue(':description', $description);
  $stmt->execute();
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_tasks', $id, 'CREATE', 'Created task');

  if($isAjax){
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
    $taskStmt->execute([':id'=>$id]);
    $taskRow = $taskStmt->fetch(PDO::FETCH_ASSOC) ?: [];
    echo json_encode(['success'=>true,'task'=>$taskRow]);
    exit;
  }
}

if($isAjax){
  echo json_encode(['success'=>false]);
  exit;
}

$redirect = $_POST['redirect'] ?? '../index.php';
header('Location: ' . $redirect);
exit;

