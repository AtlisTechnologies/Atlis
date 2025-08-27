<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','delete');

$isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest'
  || str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  } else {
    $_SESSION['error_message'] = 'Method not allowed';
    header('Location: ../index.php');
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
    header('Location: ../index.php');
  }
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>'Missing ID']);
  } else {
    $_SESSION['error_message'] = 'Missing ID';
    header('Location: ../index.php');
  }
  exit;
}

try {
  $pdo->prepare('DELETE FROM module_corporate WHERE id=:id')->execute([':id'=>$id]);
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message'] = 'Unable to delete';
    header('Location: ../index.php');
  }
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate',$id,'DELETE',null,null,'Deleted corporate');

if ($isAjax) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>true]);
} else {
  $_SESSION['message'] = 'Record deleted';
  header('Location: ../index.php');
}
exit;
