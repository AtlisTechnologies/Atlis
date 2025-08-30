<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  http_response_code(403);
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Invalid ID']);
  exit;
}

$stmt = $pdo->prepare('SELECT * FROM admin_minder_reminders_files WHERE id = :id');
$stmt->execute([':id'=>$id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$file) {
  http_response_code(404);
  echo json_encode(['success'=>false,'error'=>'File not found']);
  exit;
}

$pdo->prepare('DELETE FROM admin_minder_reminders_files WHERE id = :id')->execute([':id'=>$id]);

$path = __DIR__ . '/../../../../' . $file['file_path'];
if (is_file($path)) {
  @unlink($path);
}

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders_files', $id, 'DELETE', json_encode($file), null, 'Deleted file');

echo json_encode(['success'=>true]);
