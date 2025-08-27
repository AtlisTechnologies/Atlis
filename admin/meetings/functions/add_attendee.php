<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid CSRF token',
            'attendees' => []
        ]);
        exit;
    }

    $meeting_id = (int)($_POST['meeting_id'] ?? 0);
    $attendee_user_id = isset($_POST['attendee_user_id']) && $_POST['attendee_user_id'] !== '' ? (int)$_POST['attendee_user_id'] : null;

    $rosterStmt = $pdo->prepare(
        'SELECT a.id,
                a.attendee_user_id,
                COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name
         FROM module_meeting_attendees a
         LEFT JOIN users u ON a.attendee_user_id = u.id
         LEFT JOIN person p ON u.id = p.user_id
         WHERE a.meeting_id = ?
         ORDER BY name'
    );

    $currentRoster = [];
    if ($meeting_id) {
        $rosterStmt->execute([$meeting_id]);
        $currentRoster = $rosterStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check for existing attendee before attempting to insert
    $checkStmt = $pdo->prepare('SELECT id FROM module_meeting_attendees WHERE meeting_id = ? AND attendee_user_id = ?');
    $checkStmt->execute([$meeting_id, $attendee_user_id]);
    if ($checkStmt->fetch()) {
        echo json_encode([
            'success' => false,
            'message' => 'Attendee already added',
            'attendees' => $currentRoster
        ]);
        exit;
    }

    try {
        if ($meeting_id && $attendee_user_id) {
            $stmt = $pdo->prepare(
                'INSERT INTO module_meeting_attendees (
                    user_id,
                    user_updated,
                    meeting_id,
                    attendee_user_id
                ) VALUES (:uid,:uid,:mid,:attendee)'
            );
            $stmt->execute([
                ':uid' => $this_user_id,
                ':mid' => $meeting_id,
                ':attendee' => $attendee_user_id
            ]);
            $id = $pdo->lastInsertId();
            admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $id, 'CREATE', 'Added attendee');
        }

        // Refresh roster after successful insert
        $rosterStmt->execute([$meeting_id]);
        $attendees = $rosterStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'attendees' => $attendees]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'attendees' => $currentRoster
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request',
    'attendees' => []
]);
