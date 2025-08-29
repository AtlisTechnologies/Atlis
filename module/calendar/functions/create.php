<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$memo = trim($_POST['memo'] ?? '');

$start_time = $_POST['start_time'] ?? null;
$end_time = $_POST['end_time'] ?? null;
$link_module = $_POST['link_module'] ?? null;
$link_record_id = $_POST['link_record_id'] ?? null;
$calendar_id = (int)($_POST['calendar_id'] ?? 0);
$location = trim($_POST['location'] ?? '');
$event_type_id = isset($_POST['event_type_id']) && $_POST['event_type_id'] !== '' && $_POST['event_type_id'] !== 'Select type' ? (int)$_POST['event_type_id'] : null;
$visibility_id = (int)($_POST['visibility_id'] ?? 198);
$timezone_id = isset($_POST['timezone_id']) && $_POST['timezone_id'] !== '' ? (int)$_POST['timezone_id'] : null;
if (!in_array($visibility_id, [198, 199], true)) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid visibility_id']);
  exit;
}
$attendees = $_POST['attendees'] ?? [];
$attended = $_POST['attended'] ?? [];

if ($event_type_id !== null) {
  $etypeStmt = $pdo->prepare('SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE li.id = :id AND l.name = "CALENDAR_EVENT_TYPE"');
  $etypeStmt->execute([':id' => $event_type_id]);
  if (!$etypeStmt->fetchColumn()) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid event_type_id']);
    exit;
  }
}

if ($timezone_id !== null) {
  $tzStmt = $pdo->prepare('SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE li.id = :id AND l.name = "TIMEZONE"');
  $tzStmt->execute([':id' => $timezone_id]);
  if (!$tzStmt->fetchColumn()) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid timezone_id']);
    exit;
  }
}

if ($end_time && strtotime($start_time) >= strtotime($end_time)) {
  http_response_code(400);
  echo json_encode(['error' => 'Start time must be before end time']);
  exit;
}

if ($title && $start_time && $calendar_id) {
  $chk = $pdo->prepare('SELECT user_id FROM module_calendar WHERE id = ?');
  $chk->execute([$calendar_id]);
  $calendar = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$calendar) {
    http_response_code(404);
    exit;
  }
  if ($calendar['user_id'] != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }

  $columns = ['user_id', 'calendar_id', 'title', 'memo', 'location', 'start_time', 'end_time', 'link_module', 'link_record_id', 'visibility_id', 'timezone_id'];
  $placeholders = [':uid', ':calendar_id', ':title', ':memo', ':location', ':start_time', ':end_time', ':link_module', ':link_record_id', ':visibility_id', ':timezone_id'];
  $params = [
    ':uid' => $this_user_id,
    ':calendar_id' => $calendar_id,
    ':title' => $title,
    ':memo' => $memo,
    ':location' => $location,
    ':start_time' => $start_time,
    ':end_time' => $end_time,
    ':link_module' => $link_module,
    ':link_record_id' => $link_record_id,
    ':visibility_id' => $visibility_id,
    ':timezone_id' => $timezone_id
  ];
  if ($event_type_id !== null) {
    $columns[] = 'event_type_id';
    $placeholders[] = ':event_type_id';
    $params[':event_type_id'] = $event_type_id;
  }

  try {
    $pdo->beginTransaction();

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

    $pdo->commit();

    echo json_encode([
      'success' => true,
      'id' => $eventId,
      'calendar_id' => $calendar_id,
      'title' => $title,
      'start_time' => $start_time,
      'end_time' => $end_time,
      'location' => $location,
      'event_type_id' => $event_type_id,
      'visibility_id' => $visibility_id
    ]);
    exit;
  } catch (Exception $e) {
    if ($pdo->inTransaction()) {
      $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
    exit;
  }
}

echo json_encode(['success' => false]);
exit;
