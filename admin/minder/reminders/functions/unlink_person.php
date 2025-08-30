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

$reminder_id = isset($_POST['reminder_id']) ? (int)$_POST['reminder_id'] : 0;
$person_id   = isset($_POST['person_id']) ? (int)$_POST['person_id'] : 0;
if (!$reminder_id || !$person_id) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

$pdo->prepare('DELETE FROM admin_minder_reminders_persons WHERE reminder_id = :rid AND person_id = :pid')
    ->execute([':rid'=>$reminder_id, ':pid'=>$person_id]);

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders_persons', $reminder_id, 'DELETE', json_encode(['person_id'=>$person_id]), null, 'Unlinked person');

echo json_encode(['success'=>true]);
