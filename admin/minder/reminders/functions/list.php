<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder', 'read');

header('Content-Type: application/json');

$stmt = $pdo->query('SELECT r.id, r.title, r.description, r.remind_at, r.repeat_type, GROUP_CONCAT(ra.assigned_user_id) AS assigned_users FROM minder_reminder r LEFT JOIN minder_reminder_assignments ra ON r.id = ra.reminder_id GROUP BY r.id');
$events = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $events[] = [
    'id' => $row['id'],
    'title' => $row['title'],
    'start' => $row['remind_at'],
    'extendedProps' => [
      'description' => $row['description'],
      'repeat_type' => $row['repeat_type'],
      'assigned_users' => $row['assigned_users'] ? array_map('intval', explode(',', $row['assigned_users'])) : []
    ]
  ];
}
echo json_encode($events);
exit;
