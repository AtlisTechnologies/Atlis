<?php
require '../../../includes/php_header.php';
require_permission('calendar','read');

header('Content-Type: application/json');

$privStmt = $pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=38 AND code="PRIVATE"');
$privStmt->execute();
$privateId = $privStmt->fetchColumn();

$events = [];
if (user_has_role('Admin')) {
  $stmt = $pdo->query('SELECT id, title, start_date, end_date, related_module, related_id, user_id, event_type_id, visibility_id FROM module_calendar_events');
} else {
  $stmt = $pdo->prepare('SELECT id, title, start_date, end_date, related_module, related_id, user_id, event_type_id, visibility_id FROM module_calendar_events WHERE visibility_id != :private OR user_id = :uid');
  $stmt->execute([':private' => $privateId, ':uid' => $this_user_id]);
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if ($row['visibility_id'] == $privateId && $row['user_id'] != $this_user_id && !user_has_role('Admin')) {
    continue;
  }
  $events[] = [
    'id' => (int)$row['id'],
    'title' => $row['title'],
    'start' => $row['start_date'],
    'end' => $row['end_date'],
    'related_module' => $row['related_module'],
    'related_id' => $row['related_id'],
    'event_type_id' => $row['event_type_id'],
    'visibility_id' => $row['visibility_id']
  ];
}

echo json_encode($events);
