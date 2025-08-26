<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
  }
  $id = (int)($_POST['id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $start_raw = $_POST['start_time'] ?? '';
  $end_raw = $_POST['end_time'] ?? '';
  $recur_daily = !empty($_POST['recur_daily']) ? 1 : 0;
  $recur_weekly = !empty($_POST['recur_weekly']) ? 1 : 0;
  $recur_monthly = !empty($_POST['recur_monthly']) ? 1 : 0;
  $meeting_status_id = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
  $meeting_type_id   = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;

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
    $stmt = $pdo->prepare('UPDATE module_meetings SET user_updated=?, title=?, description=?, start_time=?, end_time=?, recur_daily=?, recur_weekly=?, recur_monthly=?, status_id=?, type_id=? WHERE id=?');
    $stmt->execute([$this_user_id, $title, $description, $start_time, $end_time, $recur_daily, $recur_weekly, $recur_monthly, $meeting_status_id, $meeting_type_id, $id]);
   admin_audit_log($pdo, $this_user_id, 'module_meeting', $id, 'UPDATE', 'Updated meeting');
    header('Location: ../index.php?action=details&id=' . $id);
    exit;
  }

  http_response_code(400);
  exit;
}

http_response_code(405);

