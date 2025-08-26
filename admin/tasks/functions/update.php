<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('admin_task', 'update');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../task.php');
  }
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  } else {
    $_SESSION['error_message'] = 'Invalid CSRF token';
    header('Location: ../task.php');
  }
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid ID']);
  } else {
    $_SESSION['error_message'] = 'Invalid ID';
    header('Location: ../task.php');
  }
  exit;
}

$oldStmt = $pdo->prepare('SELECT * FROM admin_task WHERE id = :id');
$oldStmt->execute([':id' => $id]);
$old = $oldStmt->fetch(PDO::FETCH_ASSOC);

$name = trim($_POST['name'] ?? '');
if ($name === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Name required']);
  } else {
    $_SESSION['error_message'] = 'Name required';
    header('Location: ../task.php');
  }
  exit;
}
$description = $_POST['description'] ?? null;
$type_id = $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
$sub_category_id = $_POST['sub_category_id'] !== '' ? (int)$_POST['sub_category_id'] : null;
$status_id = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$priority_id = $_POST['priority_id'] !== '' ? (int)$_POST['priority_id'] : null;
$start_date = $_POST['start_date'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$memo = $_POST['memo'] ?? null;
$assigned_user_ids = isset($_POST['assignments']) ? array_map('intval', (array)$_POST['assignments']) : [];

$pdo->prepare('UPDATE admin_task SET name=:name, description=:description, type_id=:type_id, category_id=:category_id, sub_category_id=:sub_category_id, status_id=:status_id, priority_id=:priority_id, start_date=:start_date, due_date=:due_date, memo=:memo, user_updated=:uid WHERE id=:id')
    ->execute([
      ':name' => $name,
      ':description' => $description,
      ':type_id' => $type_id,
      ':category_id' => $category_id,
      ':sub_category_id' => $sub_category_id,
      ':status_id' => $status_id,
      ':priority_id' => $priority_id,
      ':start_date' => $start_date ?: null,
      ':due_date' => $due_date ?: null,
      ':memo' => $memo,
      ':uid' => $this_user_id,
      ':id' => $id
    ]);

$pdo->prepare('DELETE FROM admin_task_assignments WHERE task_id = :id')->execute([':id' => $id]);
foreach ($assigned_user_ids as $assigned_user_id) {
  $pdo->prepare('INSERT INTO admin_task_assignments (task_id, assigned_user_id, user_id, user_updated) VALUES (:task_id, :assigned_user_id, :uid, :uid)')
      ->execute([
        ':task_id' => $id,
        ':assigned_user_id' => $assigned_user_id,
        ':uid' => $this_user_id
      ]);
}

admin_audit_log($pdo, $this_user_id, 'admin_task', $id, 'UPDATE', json_encode($old), json_encode(['name'=>$name]), 'Updated task');

if ($isAjax) {
  header('Content-Type: application/json');
  $fetchStmt = $pdo->prepare('SELECT t.id, t.name, type.label AS type_label, cat.label AS category_label, sub.label AS sub_category_label, st.label AS status_label, pr.label AS priority_label FROM admin_task t LEFT JOIN lookup_list_items type ON t.type_id = type.id LEFT JOIN lookup_list_items cat ON t.category_id = cat.id LEFT JOIN lookup_list_items sub ON t.sub_category_id = sub.id LEFT JOIN lookup_list_items st ON t.status_id = st.id LEFT JOIN lookup_list_items pr ON t.priority_id = pr.id WHERE t.id = :id');
  $fetchStmt->execute([':id' => $id]);
  $task = $fetchStmt->fetch(PDO::FETCH_ASSOC);
  echo json_encode(['success' => true, 'task' => $task]);
} else {
  $_SESSION['message'] = 'Task saved';
  header('Location: ../task.php?id=' . $id);
}
exit;
