<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$start = $_POST['start'] ?? null;
$end = $_POST['end'] ?? null;
$related_module = $_POST['related_module'] ?? null;
$related_id = $_POST['related_id'] ?? null;
$is_private = !empty($_POST['is_private']) ? 1 : 0;
$attendees = $_POST['attendees'] ?? [];

if ($title && $start) {
  $stmt = $pdo->prepare('INSERT INTO module_calendar_events (user_id, title, start_date, end_date, related_module, related_id, is_private) VALUES (:uid, :title, :start, :end, :rel_module, :rel_id, :is_private)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':title' => $title,
    ':start' => $start,
    ':end' => $end,
    ':rel_module' => $related_module,
    ':rel_id' => $related_id,
    ':is_private' => $is_private
  ]);
  $eventId = $pdo->lastInsertId();

  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_attendees (user_id, calendar_event_id, attendee_user_id) VALUES (:uid, :eid, :aid)');
    foreach ($attendees as $aid) {
      $aStmt->execute([':uid' => $this_user_id, ':eid' => $eventId, ':aid' => $aid]);
    }
  }

  echo json_encode(['success' => true, 'id' => $eventId]);
  exit;
}

echo json_encode(['success' => false]);
