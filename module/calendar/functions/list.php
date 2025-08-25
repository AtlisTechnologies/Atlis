<?php
require '../../../includes/php_header.php';
require_permission('calendar','read');

header('Content-Type: application/json');

$events = [];
if (user_has_role('Admin')) {
  $stmt = $pdo->query('SELECT id, calendar_id, title, start_date, end_date, related_module, related_id, user_id, event_type_id, is_private FROM module_calendar_events');
} else {
  $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_date, end_date, related_module, related_id, user_id, event_type_id, is_private FROM module_calendar_events WHERE is_private = 0 OR user_id = :uid');
  $stmt->execute([':uid' => $this_user_id]);
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $events[] = [
    'id' => (int)$row['id'],
    'calendar_id' => (int)$row['calendar_id'],
    'title' => $row['title'],
    'start' => $row['start_date'],
    'end' => $row['end_date'],
    'related_module' => $row['related_module'],
    'related_id' => $row['related_id'],
    'event_type_id' => $row['event_type_id'],
    'is_private' => (int)$row['is_private']
  ];
}

echo json_encode($events);
