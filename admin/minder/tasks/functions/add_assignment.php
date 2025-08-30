<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_task', 'create');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$task_id = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
$assigned_user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
if (!$task_id || !$assigned_user_id) {
  die('Missing data');
}

$pdo->prepare('INSERT INTO admin_task_assignments (task_id, assigned_user_id, user_id, user_updated) VALUES (:task_id, :assigned_user_id, :uid, :uid)')
    ->execute([
      ':task_id' => $task_id,
      ':assigned_user_id' => $assigned_user_id,
      ':uid' => $this_user_id
    ]);

admin_audit_log($pdo, $this_user_id, 'minder_task_assignments', $task_id, 'CREATE', null, json_encode(['assigned_user_id'=>$assigned_user_id]), 'Added assignment');

header('Location: ../task.php?id=' . $task_id);
