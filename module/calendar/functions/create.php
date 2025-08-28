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
$event_type_id = isset($_POST['event_type_id']) && $_POST['event_type_id'] !== '' ? (int)$_POST['event_type_id'] : null;
$visibility_id = (int)($_POST['visibility_id'] ?? 198);
$is_private   = $visibility_id === 199 ? 1 : 0;
$attendees = $_POST['attendees'] ?? [];
$attended = $_POST['attended'] ?? [];

if ($title && $start_time && $calendar_id) {
  $chk = $pdo->prepare('SELECT user_id, is_private FROM module_calendar WHERE id = ?');
  $chk->execute([$calendar_id]);
  $calendar = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$calendar) {
    http_response_code(404);
    exit;
  }
  if ($calendar['is_private'] && $calendar['user_id'] != $this_user_id && !user_has_role('Admin')) {
    // Only the owner or an Admin may add events to a private calendar.
    http_response_code(403);
    exit;
  }

  $columns = ['user_id', 'calendar_id', 'title', 'start_time', 'end_time', 'link_module', 'link_record_id', 'visibility_id'];
  $placeholders = [':uid', ':calendar_id', ':title', ':start_time', ':end_time', ':link_module', ':link_record_id', ':visibility_id'];
  $params = [
    ':uid' => $this_user_id,
    ':calendar_id' => $calendar_id,
    ':title' => $title,
    ':start_time' => $start_time,
    ':end_time' => $end_time,
    ':link_module' => $link_module,
    ':link_record_id' => $link_record_id,
    ':visibility_id' => $visibility_id
  ];
  if ($event_type_id !== null) {
    $columns[] = 'event_type_id';
    $placeholders[] = ':event_type_id';
    $params[':event_type_id'] = $event_type_id;
  }

  $sql = 'INSERT INTO module_calendar_events (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $placeholders) . ')';
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $eventId = $pdo->lastInsertId();

  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_person_attendees (user_id, event_id, attendee_person_id, attended) VALUES (:uid, :eid, :pid, :att)');
    foreach ($attendees as $idx => $pid) {
      $aStmt->execute([
        ':uid' => $calendar['user_id'],
        ':eid' => $eventId,
        ':pid' => $pid,
        ':att' => !empty($attended[$idx]) ? 1 : 0
      ]);
    }
  }

  echo json_encode([
    'success' => true,
    'id' => $eventId,
    'calendar_id' => $calendar_id,
    'title' => $title,
    'start' => $start_time,
    'end' => $end_time,
    'visibility_id' => $visibility_id,
    'is_private' => $is_private
  ]);
  exit;
}

echo json_encode(['success' => false]);
exit;
