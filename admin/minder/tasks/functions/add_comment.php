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
$comment = trim($_POST['comment'] ?? '');
if (!$task_id || $comment === '') {
  die('Missing data');
}

$pdo->prepare('INSERT INTO admin_task_comments (task_id, user_id, comment, user_updated) VALUES (:task,:uid,:comment,:uid)')
    ->execute([':task' => $task_id, ':uid' => $this_user_id, ':comment' => $comment]);
$cid = (int)$pdo->lastInsertId();

admin_audit_log($pdo, $this_user_id, 'admin_task_comments', $cid, 'CREATE', null, json_encode(['comment'=>$comment]), 'Added comment');

header('Location: ../task.php?id=' . $task_id);
