<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');

$start_date = $_POST['start_date'] ?? $_POST['startDate'] ?? null;
$end_date = $_POST['end_date'] ?? $_POST['endDate'] ?? null;
$related_module = $_POST['related_module'] ?? $_POST['link_module'] ?? null;
$related_id = $_POST['related_id'] ?? $_POST['link_record_id'] ?? null;
$calendar_id = (int)($_POST['calendar_id'] ?? 0);
$event_type_id = $_POST['event_type_id'] ?? null;
$visibility_id = (int)($_POST['visibility_id'] ?? 0);
$attendees = $_POST['attendees'] ?? [];

if ($title && $start_date && $calendar_id) {
  $stmt = $pdo->prepare('INSERT INTO module_calendar_events (user_id, calendar_id, title, start_date, end_date, event_type_id, related_module, related_id, visibility_id) VALUES (:uid, :calendar_id, :title, :start_date, :end_date, :event_type_id, :related_module, :related_id, :visibility_id)');

  $stmt->execute([
    ':uid' => $this_user_id,
    ':calendar_id' => $calendar_id,
    ':title' => $title,
    ':start_date' => $start_date,
    ':end_date' => $end_date,
    ':event_type_id' => $event_type_id,
    ':related_module' => $related_module,
    ':related_id' => $related_id,
    ':visibility_id' => $visibility_id

  ]);
  $eventId = $pdo->lastInsertId();

  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_event_attendees (user_id, event_id, attendee_user_id) VALUES (:uid, :eid, :aid)');
    foreach ($attendees as $aid) {
      $aStmt->execute([':uid' => $this_user_id, ':eid' => $eventId, ':aid' => $aid]);
    }
  }

  echo json_encode(['success' => true, 'id' => $eventId, 'visibility_id' => $visibility_id]);
  exit;
}

echo json_encode(['success' => false]);
