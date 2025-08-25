<?php
require '../../../includes/php_header.php';
require_permission('calendar','update');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$start = $_POST['start'] ?? null;
$end = $_POST['end'] ?? null;
$related_module = $_POST['related_module'] ?? null;
$related_id = $_POST['related_id'] ?? null;
$is_private = !empty($_POST['is_private']) ? 1 : 0;
$attendees = $_POST['attendees'] ?? [];

if ($id && $title && $start) {
  $chk = $pdo->prepare('SELECT user_id, is_private FROM module_calendar_events WHERE id = ?');
  $chk->execute([$id]);
  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }
  if ($existing['is_private'] && $existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }

  $stmt = $pdo->prepare('UPDATE module_calendar_events SET user_updated=?, title=?, start_date=?, end_date=?, related_module=?, related_id=?, is_private=? WHERE id=?');
  $stmt->execute([$this_user_id, $title, $start, $end, $related_module, $related_id, $is_private, $id]);

  $pdo->prepare('DELETE FROM module_calendar_event_attendees WHERE event_id=?')->execute([$id]);
  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_event_attendees (user_id, event_id, attendee_user_id) VALUES (:uid, :eid, :aid)');
    foreach ($attendees as $aid) {
      $aStmt->execute([':uid' => $this_user_id, ':eid' => $id, ':aid' => $aid]);
    }
  }

  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);
