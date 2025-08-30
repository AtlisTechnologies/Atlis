<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder','create');

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

  $title = trim($_POST['title'] ?? '');
  if ($title === '') {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Title required']);
    exit;
  }
$description = $_POST['description'] ?? null;
$remind_at = $_POST['remind_at'] ?? null;
$type_id = $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
$status_id = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$person_ids = isset($_POST['person_ids']) ? array_map('intval', (array)$_POST['person_ids']) : [];
$contractor_ids = isset($_POST['contractor_ids']) ? array_map('intval', (array)$_POST['contractor_ids']) : [];

$reminderId = 0;
try {
  $stmt = $pdo->prepare('INSERT INTO admin_minder_reminders (title, description, remind_at, type_id, status_id, user_id, user_updated) VALUES (:title,:description,:remind_at,:type_id,:status_id,:uid,:uid)');
  $stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':remind_at' => $remind_at ?: null,
    ':type_id' => $type_id,
    ':status_id' => $status_id,
    ':uid' => $this_user_id
  ]);
  $reminderId = (int)$pdo->lastInsertId();
  foreach ($person_ids as $pid) {
    $pdo->prepare('INSERT INTO admin_minder_reminders_persons (reminder_id, person_id, user_id, user_updated) VALUES (:rid,:pid,:uid,:uid)')
        ->execute([':rid'=>$reminderId, ':pid'=>$pid, ':uid'=>$this_user_id]);
  }
  foreach ($contractor_ids as $cid) {
    $pdo->prepare('INSERT INTO admin_minder_reminders_contractors (reminder_id, contractor_id, user_id, user_updated) VALUES (:rid,:cid,:uid,:uid)')
        ->execute([':rid'=>$reminderId, ':cid'=>$cid, ':uid'=>$this_user_id]);
  }
} catch (PDOException $e) {
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  exit;
}

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders', $reminderId, 'CREATE', null, json_encode(['title'=>$title]), 'Created reminder');

echo json_encode(['success'=>true,'id'=>$reminderId]);
exit;
