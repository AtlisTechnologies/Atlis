<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$start = $_POST['start'] ?? null;
$end = $_POST['end'] ?? null;
$related_module = $_POST['related_module'] ?? null;
$related_id = $_POST['related_id'] ?? null;
$event_type_id = $_POST['event_type_id'] ?? null;
$visibility_id = $_POST['visibility_id'] ?? null;
$attendees = $_POST['attendees'] ?? [];

if ($title && $start) {
  $stmt = $pdo->prepare('INSERT INTO module_calendar_events (user_id, title, start_date, end_date, event_type_id, visibility_id, related_module, related_id) VALUES (:uid, :title, :start, :end, :etype, :vis, :rel_module, :rel_id)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':title' => $title,
    ':start' => $start,
    ':end' => $end,
    ':etype' => $event_type_id,
    ':vis' => $visibility_id,
    ':rel_module' => $related_module,
    ':rel_id' => $related_id
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
