<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder', 'delete');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
    || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json', true, 405);
    echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../index.php');
  }
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  if ($isAjax) {
    header('Content-Type: application/json', true, 403);
    echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  } else {
    $_SESSION['error_message'] = 'Invalid CSRF token';
    header('Location: ../index.php');
  }
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
  if ($isAjax) {
    header('Content-Type: application/json', true, 400);
    echo json_encode(['success'=>false,'error'=>'Invalid ID']);
  } else {
    $_SESSION['error_message'] = 'Invalid ID';
    header('Location: ../index.php');
  }
  exit;
}

try {
  $pdo->prepare('DELETE FROM minder_reminder WHERE id=:id')->execute([':id'=>$id]);
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message']='Unable to delete reminder';
    header('Location: ../index.php');
  }
  exit;
}

admin_audit_log($pdo, $this_user_id, 'minder_reminder', $id, 'DELETE', null, null, 'Deleted reminder');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true]);
} else {
  $_SESSION['message'] = 'Reminder deleted';
  header('Location: ../index.php');
}
exit;
