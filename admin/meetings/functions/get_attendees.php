<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$data = $method === 'POST' ? $_POST : $_GET;

try {
    if (!verify_csrf_token($data['csrf_token'] ?? '')) {
        throw new Exception('Invalid CSRF token');
    }

    $meeting_id = (int)($data['meeting_id'] ?? 0);
    if (!$meeting_id) {
        throw new Exception('Invalid meeting id');
    }

    $stmt = $pdo->prepare(
        'SELECT a.id,
                a.attendee_person_id,
                a.attendee_user_id,
                COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name
         FROM module_meeting_attendees a
         LEFT JOIN person p ON a.attendee_user_id = p.user_id
         LEFT JOIN users u ON a.attendee_user_id = u.id
         WHERE a.meeting_id = ?
         ORDER BY name'
    );
    $stmt->execute([$meeting_id]);
    $attendees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'attendees' => $attendees]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

