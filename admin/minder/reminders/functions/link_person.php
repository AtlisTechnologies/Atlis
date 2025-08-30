<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('minder_reminder','update');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  } else {
    die('Invalid CSRF token');
  }
  exit;
}

$reminder_id = isset($_POST['reminder_id']) ? (int)$_POST['reminder_id'] : 0;
$person_id = isset($_POST['person_id']) ? (int)$_POST['person_id'] : 0;
if (!$reminder_id || !$person_id) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Missing data']);
  } else {
    die('Missing data');
  }
  exit;
}

$pdo->prepare('INSERT INTO admin_minder_reminders_person (reminder_id, person_id, user_id, user_updated) VALUES (:rid,:pid,:uid,:uid)')
    ->execute([':rid'=>$reminder_id, ':pid'=>$person_id, ':uid'=>$this_user_id]);

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders_person', $reminder_id, 'CREATE', null, json_encode(['person_id'=>$person_id]), 'Linked person');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true]);
} else {
  header('Location: ../reminder.php?id=' . $reminder_id);
}
