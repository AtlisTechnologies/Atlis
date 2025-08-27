<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','create');

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

$name = trim($_POST['name'] ?? '');
if ($name === '') {
  if ($isAjax) {
    header('Content-Type: application/json');
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Name required']);
  } else {
    $_SESSION['error_message'] = 'Name required';
    header('Location: ../index.php');
  }
  exit;
}
$feature_id = $_POST['feature_id'] !== '' ? (int)$_POST['feature_id'] : null;
$memo = $_POST['memo'] ?? null;

$id = 0;
try {
  $stmt = $pdo->prepare('INSERT INTO module_corporate (name, feature_id, memo, user_id, user_updated) VALUES (:name,:feature,:memo,:uid,:uid)');
  $stmt->execute([
    ':name'=>$name,
    ':feature'=>$feature_id,
    ':memo'=>$memo,
    ':uid'=>$this_user_id
  ]);
  $id = (int)$pdo->lastInsertId();
} catch (PDOException $e) {
  if ($isAjax) {
    header('Content-Type: application/json');
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  } else {
    $_SESSION['error_message'] = 'Unable to save record';
    header('Location: ../index.php');
  }
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate',$id,'CREATE',null,json_encode(['name'=>$name]),'Created corporate');

if ($isAjax) {
  $fetch = $pdo->prepare('SELECT c.id, c.name, f.label AS feature_label FROM module_corporate c LEFT JOIN lookup_list_items f ON c.feature_id=f.id WHERE c.id=:id');
  $fetch->execute([':id'=>$id]);
  $record = $fetch->fetch(PDO::FETCH_ASSOC);
  header('Content-Type: application/json');
  echo json_encode(['success'=>true,'corporate'=>$record]);
} else {
  $_SESSION['message'] = 'Record saved';
  header('Location: ../index.php');
}
exit;
