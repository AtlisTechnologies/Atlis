<?php
require '../../../includes/php_header.php';

require_permission('calendar','update');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$memo = trim($_POST['memo'] ?? '');

$start_time = $_POST['start_time'] ?? null;
$end_time = $_POST['end_time'] ?? null;
$link_module = $_POST['link_module'] ?? null;
$link_record_id = $_POST['link_record_id'] ?? null;
$calendar_id = (int)($_POST['calendar_id'] ?? 0);
$event_type_id = isset($_POST['event_type_id']) && $_POST['event_type_id'] !== '' ? (int)$_POST['event_type_id'] : null;
$visibility_id = (int)($_POST['visibility_id'] ?? 198);
if (!in_array($visibility_id, [198, 199], true)) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid visibility_id']);
  exit;
}
$is_private   = $visibility_id === 199 ? 1 : 0;
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

if ($end_time && strtotime($start_time) >= strtotime($end_time)) {
  http_response_code(400);
  echo json_encode(['error' => 'Start time must be before end time']);
  exit;
}

if ($id && $title && $start_time && $calendar_id) {
  $chk = $pdo->prepare('SELECT e.user_id, e.visibility_id, e.calendar_id, e.event_type_id, c.user_id AS calendar_owner FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE e.id = ?');
  $chk->execute([$id]);
  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }

  $calendarChk = $pdo->prepare('SELECT user_id, is_private FROM module_calendar WHERE id = ?');
  $calendarChk->execute([$calendar_id]);
  $calendar = $calendarChk->fetch(PDO::FETCH_ASSOC);
  if (!$calendar) {
    http_response_code(404);
    exit;
  }

  if ($existing['user_id'] != $this_user_id && !user_has_role('Admin')) {

    http_response_code(403);
    exit;
  }
  if ($calendar['is_private'] && $calendar['user_id'] != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }
  if ($existing['visibility_id'] == 199 && $existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    // Prevent non-owners from editing private events unless they are Admins.
    http_response_code(403);
    exit;
  }

  $fields = [
    'user_updated = :user_updated',
    'calendar_id = :calendar_id',
    'title = :title',
    'memo = :memo',
    'start_time = :start_time',
    'end_time = :end_time',
    'link_module = :link_module',
    'link_record_id = :link_record_id',
    'visibility_id = :visibility_id'
  ];

  $params = [
    ':user_updated' => $this_user_id,
    ':calendar_id' => $calendar_id,
    ':title' => $title,
    ':memo' => $memo,
    ':start_time' => $start_time,
    ':end_time' => $end_time,
    ':link_module' => $link_module,
    ':link_record_id' => $link_record_id,
    ':visibility_id' => $visibility_id,
    ':id' => $id
  ];

  if ($event_type_id !== null) {
    $fields[] = 'event_type_id = :event_type_id';
    $params[':event_type_id'] = $event_type_id;
  }

  try {
    $pdo->beginTransaction();

    $sql = 'UPDATE module_calendar_events SET ' . implode(', ', $fields) . ' WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $pdo->prepare('DELETE FROM module_calendar_person_attendees WHERE event_id=?')->execute([$id]);
    if (is_array($attendees)) {
      $aStmt = $pdo->prepare('INSERT INTO module_calendar_person_attendees (user_id, event_id, attendee_person_id, attended) VALUES (:uid, :eid, :pid, :att)');
      foreach ($attendees as $idx => $pid) {
        $aStmt->execute([
          ':uid' => $calendar['user_id'],
          ':eid' => $id,
          ':pid' => $pid,
          ':att' => !empty($attended[$idx]) ? 1 : 0
        ]);
      }
    }

    $pdo->commit();

    echo json_encode([
      'success' => true,
      'id' => $id,
      'calendar_id' => $calendar_id,
      'title' => $title,
      'description' => $memo,
      'start' => $start_time,
      'end' => $end_time,
      'event_type_id' => $event_type_id !== null ? $event_type_id : ($existing['event_type_id'] ?? null),
      'visibility_id' => $visibility_id,
      'is_private' => $is_private
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
