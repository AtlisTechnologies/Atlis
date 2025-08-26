<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/php_header.php';
require_permission('admin_task','create');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$name = trim($_POST['name'] ?? '');
if ($name === '') {
  $_SESSION['error_message'] = 'Name required';
  header('Location: ../task.php');
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
$assignments = isset($_POST['assignments']) ? array_map('intval', (array)$_POST['assignments']) : [];

$stmt = $pdo->prepare('INSERT INTO admin_task (name, description, type_id, category_id, sub_category_id, status_id, priority_id, start_date, due_date, memo, user_id, user_updated) VALUES (:name,:description,:type_id,:category_id,:sub_category_id,:status_id,:priority_id,:start_date,:due_date,:memo,:uid,:uid)');
$stmt->execute([
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
  ':uid' => $this_user_id
]);
$taskId = (int)$pdo->lastInsertId();

foreach ($assignments as $uid) {
  $pdo->prepare('INSERT INTO admin_task_assignments (task_id, user_id, user_updated) VALUES (:task_id, :user_id, :uid)')
      ->execute([':task_id' => $taskId, ':user_id' => $uid, ':uid' => $this_user_id]);
}

admin_audit_log($pdo, $this_user_id, 'admin_task', $taskId, 'CREATE', null, json_encode(['name'=>$name]), 'Created task');

header('Location: ../task.php?id=' . $taskId);
