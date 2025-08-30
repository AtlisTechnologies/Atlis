<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('minder_reminder','update');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../reminder.php');
  }
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  } else {
    $_SESSION['error_message'] = 'Invalid CSRF token';
    header('Location: ../reminder.php');
  }
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Invalid ID']);
  } else {
    $_SESSION['error_message'] = 'Invalid ID';
    header('Location: ../reminder.php');
  }
  exit;
}

$title = trim($_POST['title'] ?? '');
if ($title === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Title required']);
  } else {
    $_SESSION['error_message'] = 'Title required';
    header('Location: ../reminder.php?id=' . $id);
  }
  exit;
}
$description = $_POST['description'] ?? null;
$remind_at = $_POST['remind_at'] ?? null;
$type_id = $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
$status_id = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$person_ids = isset($_POST['person_ids']) ? array_map('intval', (array)$_POST['person_ids']) : [];
$contractor_ids = isset($_POST['contractor_ids']) ? array_map('intval', (array)$_POST['contractor_ids']) : [];

try {
  $oldStmt = $pdo->prepare('SELECT * FROM admin_minder_reminders WHERE id = :id');
  $oldStmt->execute([':id'=>$id]);
  $old = $oldStmt->fetch(PDO::FETCH_ASSOC);
  if (!$old) {
    throw new Exception('Reminder not found');
  }
  $stmt = $pdo->prepare('UPDATE admin_minder_reminders SET title=:title, description=:description, remind_at=:remind_at, type_id=:type_id, status_id=:status_id, user_updated=:uid WHERE id=:id');
  $stmt->execute([
    ':title' => $title,
    ':description' => $description,
    ':remind_at' => $remind_at ?: null,
    ':type_id' => $type_id,
    ':status_id' => $status_id,
    ':uid' => $this_user_id,
    ':id' => $id
  ]);
  $pdo->prepare('DELETE FROM admin_minder_reminders_person WHERE reminder_id = :id')->execute([':id'=>$id]);
  foreach ($person_ids as $pid) {
    $pdo->prepare('INSERT INTO admin_minder_reminders_person (reminder_id, person_id, user_id, user_updated) VALUES (:rid,:pid,:uid,:uid)')
        ->execute([':rid'=>$id, ':pid'=>$pid, ':uid'=>$this_user_id]);
  }
  $pdo->prepare('DELETE FROM admin_minder_reminders_contractor WHERE reminder_id = :id')->execute([':id'=>$id]);
  foreach ($contractor_ids as $cid) {
    $pdo->prepare('INSERT INTO admin_minder_reminders_contractor (reminder_id, contractor_id, user_id, user_updated) VALUES (:rid,:cid,:uid,:uid)')
        ->execute([':rid'=>$id, ':cid'=>$cid, ':uid'=>$this_user_id]);
  }
} catch (Exception $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message'] = 'Unable to update reminder';
    header('Location: ../reminder.php?id=' . $id);
  }
  exit;
}

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders', $id, 'UPDATE', json_encode($old), json_encode(['title'=>$title]), 'Updated reminder');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true]);
} else {
  $_SESSION['message'] = 'Reminder updated';
  header('Location: ../reminder.php?id=' . $id);
}
exit;
