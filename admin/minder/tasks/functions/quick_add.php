<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_task', 'create');

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
  header('Location: ../index.php');
  exit;
}

$statusStmt = $pdo->prepare("SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'ADMIN_TASK_STATUS' AND li.code = 'NEW' LIMIT 1");
$statusStmt->execute();
$statusId = (int)$statusStmt->fetchColumn();
if (!$statusId) { $statusId = null; }

$stmt = $pdo->prepare('INSERT INTO admin_task (name, status_id, user_id, user_updated) VALUES (:name, :status_id, :uid, :uid)');
$stmt->execute([':name' => $name, ':status_id' => $statusId, ':uid' => $this_user_id]);
$taskId = (int)$pdo->lastInsertId();

$pdo->prepare('INSERT INTO admin_task_assignments (task_id, assigned_user_id, user_id, user_updated) VALUES (:task_id, :assigned_user_id, :uid, :uid)')
    ->execute([
      ':task_id' => $taskId,
      ':assigned_user_id' => $this_user_id,
      ':uid' => $this_user_id
    ]);

admin_audit_log($pdo, $this_user_id, 'admin_task', $taskId, 'CREATE', null, json_encode(['name'=>$name]), 'Quick add');

header('Location: ../index.php');
