<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder', 'create');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json', true, 405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../reminder.php');
  }
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json', true, 403);
    echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  } else {
    $_SESSION['error_message'] = 'Invalid CSRF token';
    header('Location: ../reminder.php');
  }
  exit;
}

$title = trim($_POST['title'] ?? '');
$remind_at = $_POST['remind_at'] ?? '';
if ($title === '' || $remind_at === '') {
  $error = 'Title and Remind At required';
  if ($isAjax) {
    header('Content-Type: application/json', true, 400);
    echo json_encode(['success'=>false,'error'=>$error]);
  } else {
    $_SESSION['error_message'] = $error;
    header('Location: ../reminder.php');
  }
  exit;
}
$description = $_POST['description'] ?? null;
$repeat_type = $_POST['repeat_type'] ?? null;
$memo = $_POST['memo'] ?? null;
$assigned_user_ids = isset($_POST['assignments']) ? array_map('intval',(array)$_POST['assignments']) : [];

$reminderId = 0;
try {
  $stmt = $pdo->prepare('INSERT INTO minder_reminder (title, description, remind_at, repeat_type, memo, user_id, user_updated) VALUES (:title,:description,:remind_at,:repeat_type,:memo,:uid,:uid)');
  $stmt->execute([
    ':title'=>$title,
    ':description'=>$description,
    ':remind_at'=>$remind_at,
    ':repeat_type'=>$repeat_type,
    ':memo'=>$memo,
    ':uid'=>$this_user_id
  ]);
  $reminderId = (int)$pdo->lastInsertId();
  foreach ($assigned_user_ids as $assigned_user_id) {
    $pdo->prepare('INSERT INTO minder_reminder_assignments (reminder_id, assigned_user_id, user_id, user_updated) VALUES (:rid,:aid,:uid,:uid)')
        ->execute([':rid'=>$reminderId, ':aid'=>$assigned_user_id, ':uid'=>$this_user_id]);
  }
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message']='Unable to save reminder';
    header('Location: ../reminder.php');
  }
  exit;
}

admin_audit_log($pdo, $this_user_id, 'minder_reminder', $reminderId, 'CREATE', null, json_encode(['title'=>$title]), 'Created reminder');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true,'reminder_id'=>$reminderId]);
} else {
  $_SESSION['message'] = 'Reminder saved';
  header('Location: ../reminder.php?id=' . $reminderId);
}
exit;
