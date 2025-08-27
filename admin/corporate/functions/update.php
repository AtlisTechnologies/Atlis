<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','update');

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

$name = trim($_POST['name'] ?? '');
if ($name === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>'Name required']);
  } else {
    $_SESSION['error_message'] = 'Name required';
    header('Location: ../index.php');
  }
  exit;
}
$feature_id = $_POST['feature_id'] !== '' ? (int)$_POST['feature_id'] : null;
$memo = $_POST['memo'] ?? null;

try {
  $stmt = $pdo->prepare('UPDATE module_corporate SET name=:name, feature_id=:feature, memo=:memo, user_updated=:uid WHERE id=:id');
  $stmt->execute([
    ':name'=>$name,
    ':feature'=>$feature_id,
    ':memo'=>$memo,
    ':uid'=>$this_user_id,
    ':id'=>$id
  ]);
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message'] = 'Unable to update record';
    header('Location: ../index.php');
  }
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate',$id,'UPDATE',null,json_encode(['name'=>$name]),'Updated corporate');

if ($isAjax) {
  $fetch = $pdo->prepare('SELECT c.id, c.name, f.label AS feature_label FROM module_corporate c LEFT JOIN lookup_list_items f ON c.feature_id=f.id WHERE c.id=:id');
  $fetch->execute([':id'=>$id]);
  $record = $fetch->fetch(PDO::FETCH_ASSOC);
  header('Content-Type: application/json');
  echo json_encode(['success'=>true,'corporate'=>$record]);
} else {
  $_SESSION['message'] = 'Record updated';
  header('Location: ../index.php');
}
exit;
