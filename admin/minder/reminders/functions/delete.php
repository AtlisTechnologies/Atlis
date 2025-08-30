<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder','delete');

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

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Invalid ID']);
  exit;
}

$oldStmt = $pdo->prepare('SELECT * FROM admin_minder_reminders WHERE id = :id');
$oldStmt->execute([':id'=>$id]);
$old = $oldStmt->fetch(PDO::FETCH_ASSOC);

$pdo->prepare('DELETE FROM admin_minder_reminders_files WHERE reminder_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_reminders_persons WHERE reminder_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_reminders_contractors WHERE reminder_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_reminders WHERE id = :id')->execute([':id'=>$id]);

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders', $id, 'DELETE', json_encode($old), null, 'Deleted reminder');

echo json_encode(['success'=>true]);
