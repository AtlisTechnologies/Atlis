<?php
require '../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');
$meeting_id = (int)($_GET['meeting_id'] ?? 0);

if ($meeting_id) {
    $stmt = $pdo->prepare('SELECT a.id, a.attendee_user_id, a.role, a.check_in_time, a.check_out_time, CONCAT(u.first_name, " ", u.last_name) AS name FROM module_meeting_attendees a LEFT JOIN users u ON a.attendee_user_id = u.id WHERE a.meeting_id = ? ORDER BY a.id');
    $stmt->execute([$meeting_id]);
    $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'attendees' => $attendees]);
    exit;
}

echo json_encode(['success' => false, 'attendees' => []]);

