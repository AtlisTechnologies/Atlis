<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'create');

$isAjax = isset($_POST['ajax']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
if ($isAjax) {
  header('Content-Type: application/json');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $start_raw = $_POST['start_time'] ?? '';
  $end_raw = $_POST['end_time'] ?? '';
  $recur_daily = !empty($_POST['recur_daily']) ? 1 : 0;
  $recur_weekly = !empty($_POST['recur_weekly']) ? 1 : 0;
  $recur_monthly = !empty($_POST['recur_monthly']) ? 1 : 0;

  $errors = [];
  if ($title === '') {
    $errors[] = 'Title is required';
  }
  $start_dt = DateTime::createFromFormat('Y-m-d\\TH:i', $start_raw);
  if (!$start_dt) {
    $errors[] = 'Invalid start time';
  }
  $end_dt = null;
  if ($end_raw !== '') {
    $end_dt = DateTime::createFromFormat('Y-m-d\\TH:i', $end_raw);
    if (!$end_dt) {
      $errors[] = 'Invalid end time';
    } elseif ($start_dt && $end_dt <= $start_dt) {
      $errors[] = 'End time must be after start time';
    }
  }

  if (empty($errors)) {
    $start_time = $start_dt ? $start_dt->format('Y-m-d H:i:s') : null;
    $end_time = $end_dt ? $end_dt->format('Y-m-d H:i:s') : null;
    $stmt = $pdo->prepare('INSERT INTO module_meetings (user_id, user_updated, title, description, start_time, end_time, recur_daily, recur_weekly, recur_monthly) VALUES (?,?,?,?,?,?,?,?,?)');
    $stmt->execute([$this_user_id, $this_user_id, $title, $description, $start_time, $end_time, $recur_daily, $recur_weekly, $recur_monthly]);
    $id = $pdo->lastInsertId();
   admin_audit_log($pdo, $this_user_id, 'module_meeting', $id, 'CREATE', 'Created meeting');
    $meeting = ['id'=>$id,'title'=>$title,'start_time'=>$start_time];
    if ($isAjax) {
      echo json_encode(['success'=>true,'meeting'=>$meeting]);
      exit;
    }
    header('Location: ../index.php');
    exit;
  }

  if ($isAjax) {
    echo json_encode(['success'=>false,'errors'=>$errors]);
    exit;
  }
}

if ($isAjax) {
  echo json_encode(['success'=>false]);
  exit;
}

header('Location: ../index.php');
exit;

