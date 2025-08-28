<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$data = $method === 'POST' ? $_POST : $_GET;
$meeting_id = (int)($data['meeting_id'] ?? 0);

if (!verify_csrf_token($data['csrf_token'] ?? '')) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid CSRF token',
        'attendees' => []
    ]);
    exit;
}

if ($meeting_id) {
    $stmt = $pdo->prepare(
        'SELECT a.id,
                a.attendee_person_id,
                a.attendee_user_id,
                COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name
         FROM module_meeting_attendees a
         JOIN person p ON a.attendee_person_id = p.id
         LEFT JOIN users u ON p.user_id = u.id
         WHERE a.meeting_id = ?
         ORDER BY name'
    );
    $stmt->execute([$meeting_id]);
    $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'attendees' => $attendees]);
    exit;
}

echo json_encode([
    'success' => false,
    'attendees' => []
]);

