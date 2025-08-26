<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('admin_task', 'delete');

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST' && $method !== 'GET') {
  http_response_code(405);
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (int)($_GET['id'] ?? 0);
$token = $_POST['csrf_token'] ?? ($_GET['csrf_token'] ?? '');
if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
  die('Invalid CSRF token');
}
if (!$id) {
  die('Invalid ID');
}

$oldStmt = $pdo->prepare('SELECT * FROM admin_task WHERE id = :id');
$oldStmt->execute([':id' => $id]);
$old = $oldStmt->fetch(PDO::FETCH_ASSOC);

$pdo->prepare('DELETE FROM admin_task WHERE id = :id')->execute([':id' => $id]);
$pdo->prepare('DELETE FROM admin_task_assignments WHERE task_id = :id')->execute([':id' => $id]);
$pdo->prepare('DELETE FROM admin_task_comments WHERE task_id = :id')->execute([':id' => $id]);
$pdo->prepare('DELETE FROM admin_task_files WHERE task_id = :id')->execute([':id' => $id]);

admin_audit_log($pdo, $this_user_id, 'admin_task', $id, 'DELETE', json_encode($old), null, 'Deleted task');

header('Location: ../index.php');
