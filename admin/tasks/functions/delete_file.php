<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('admin_task', 'delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) { die('Invalid ID'); }

$stmt = $pdo->prepare('SELECT task_id, file_path FROM admin_task_files WHERE id = :id');
$stmt->execute([':id' => $id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if ($file) {
  $pdo->prepare('DELETE FROM admin_task_files WHERE id = :id')->execute([':id' => $id]);
  $path = dirname(__DIR__, 2) . '/' . basename($file['file_path']);
  $fullPath = realpath(__DIR__ . '/../uploads/' . basename($file['file_path']));
  if ($fullPath && file_exists($fullPath)) {
    unlink($fullPath);
  }
  admin_audit_log($pdo, $this_user_id, 'admin_task_files', $id, 'DELETE', json_encode($file), null, 'Deleted file');
  header('Location: ../task.php?id=' . $file['task_id']);
} else {
  header('Location: ../index.php');
}
