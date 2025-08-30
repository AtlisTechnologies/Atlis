<?php
require '../../../includes/php_header.php';
require_permission('person', 'read');

header('Content-Type: application/json');

$token = $_GET['csrf_token'] ?? '';
if (!verify_csrf_token($token)) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$q = trim($_GET['q'] ?? '');
$meeting_id = (int)($_GET['meeting_id'] ?? 0);
if ($q === '' && $meeting_id === 0) {
    $sql = 'SELECT p.id, COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name, p.user_id
            FROM person p
            LEFT JOIN users u ON p.user_id = u.id
            ORDER BY name
            LIMIT 10';
    $params = [];
} else {
    $sql = 'SELECT p.id, COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name, p.user_id
            FROM person p
            LEFT JOIN users u ON p.user_id = u.id';

    $conditions = [];
    $params = [];

    if ($meeting_id) {
        $conditions[] = 'p.id NOT IN (
            SELECT attendee_person_id
            FROM module_meeting_attendees
            WHERE meeting_id = :mid AND attendee_person_id IS NOT NULL
        )';
        $params[':mid'] = $meeting_id;
    }

    if ($q !== '') {
        $conditions[] = 'COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) LIKE :q';
        $params[':q'] = "%$q%";
    }

    if ($conditions) {
        $sql .= ' WHERE ' . implode(' AND ', $conditions);
    }

    $sql .= ' ORDER BY name LIMIT 10';
}

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_THROW_ON_ERROR);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

