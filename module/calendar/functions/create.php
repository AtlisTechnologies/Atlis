<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');

$start_time = $_POST['start_time'] ?? null;
$end_time = $_POST['end_time'] ?? null;
$link_module = $_POST['link_module'] ?? null;
$link_record_id = $_POST['link_record_id'] ?? null;
$calendar_id = (int)($_POST['calendar_id'] ?? 0);
$event_type_id = $_POST['event_type_id'] ?? null;
$is_private = !empty($_POST['is_private']) ? 1 : 0;
$visibility_id = $is_private ? 199 : 198;
$attendees = $_POST['attendees'] ?? [];

if ($title && $start_time && $calendar_id) {
  $stmt = $pdo->prepare('INSERT INTO module_calendar_events (user_id, calendar_id, title, start_time, end_time, event_type_id, link_module, link_record_id, visibility_id) VALUES (:uid, :calendar_id, :title, :start_time, :end_time, :event_type_id, :link_module, :link_record_id, :visibility_id)');

  $stmt->execute([
    ':uid' => $this_user_id,
    ':calendar_id' => $calendar_id,
    ':title' => $title,
    ':start_time' => $start_time,
    ':end_time' => $end_time,
    ':event_type_id' => $event_type_id,
    ':link_module' => $link_module,
    ':link_record_id' => $link_record_id,
    ':visibility_id' => $visibility_id

  ]);
  $eventId = $pdo->lastInsertId();

  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_event_attendees (user_id, event_id, attendee_user_id) VALUES (:uid, :eid, :aid)');
    foreach ($attendees as $aid) {
      $aStmt->execute([':uid' => $this_user_id, ':eid' => $eventId, ':aid' => $aid]);
    }
  }

  echo json_encode([
    'success' => true,
    'id' => $eventId,
    'title' => $title,
    'start' => $start_time,
    'end' => $end_time,
    'is_private' => $is_private
  ]);
  exit;
}

echo json_encode(['success' => false]);
