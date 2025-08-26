<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/php_header.php';
require_permission('admin_task_comment','delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) { die('Invalid ID'); }

$stmt = $pdo->prepare('SELECT task_id, comment FROM admin_task_comments WHERE id = :id');
$stmt->execute([':id' => $id]);
$comment = $stmt->fetch(PDO::FETCH_ASSOC);
if ($comment) {
  $pdo->prepare('DELETE FROM admin_task_comments WHERE id = :id')->execute([':id' => $id]);
  admin_audit_log($pdo, $this_user_id, 'admin_task_comments', $id, 'DELETE', json_encode($comment), null, 'Deleted comment');
  header('Location: ../task.php?id=' . $comment['task_id']);
} else {
  header('Location: ../index.php');
}
