<?php
require '../../../includes/php_header.php';
require_permission('calendar','read');

header('Content-Type: application/json');

$events = [];
if (user_has_role('Admin')) {
  $stmt = $pdo->query('SELECT id, calendar_id, title, start_time, end_time, event_type_id, link_module, link_record_id, user_id, is_private FROM module_calendar_events');
} else {
  $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, event_type_id, link_module, link_record_id, user_id, is_private FROM module_calendar_events WHERE is_private = 0 OR user_id = :uid');
  $stmt->execute([':uid' => $this_user_id]);
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if ($row['is_private'] && $row['user_id'] != $this_user_id && !user_has_role('Admin')) {
    continue;
  }
  $events[] = [
    'id' => (int)$row['id'],
    'calendar_id' => (int)$row['calendar_id'],
    'title' => $row['title'],
    'start' => $row['start_time'],
    'end' => $row['end_time'],
    'event_type_id' => $row['event_type_id'],
    'link_module' => $row['link_module'],
    'link_record_id' => $row['link_record_id']
  ];
}

echo json_encode($events);
