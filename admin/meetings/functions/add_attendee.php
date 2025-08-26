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
    $role = trim($_POST['role'] ?? '');
    $check_in_time = isset($_POST['check_in_time']) && $_POST['check_in_time'] !== '' ? $_POST['check_in_time'] : null;
    $check_out_time = isset($_POST['check_out_time']) && $_POST['check_out_time'] !== '' ? $_POST['check_out_time'] : null;

    try {
        if ($meeting_id && $attendee_user_id) {
            $stmt = $pdo->prepare(
                'INSERT INTO module_meeting_attendees (
                    user_id,
                    user_updated,
                    meeting_id,
                    attendee_user_id,
                    role,
                    check_in_time,
                    check_out_time
                ) VALUES (:uid,:uid,:mid,:attendee,:role,:check_in,:check_out)'
            );
            $stmt->execute([
                ':uid' => $this_user_id,
                ':mid' => $meeting_id,
                ':attendee' => $attendee_user_id,
                ':role' => $role !== '' ? $role : null,
                ':check_in' => $check_in_time,
                ':check_out' => $check_out_time
            ]);
            $id = $pdo->lastInsertId();
            admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $id, 'CREATE', 'Added attendee');
        }

        $rosterStmt = $pdo->prepare(
            'SELECT a.id,
                    a.attendee_user_id,
                    a.role,
                    a.check_in_time,
                    a.check_out_time,
                    COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name
             FROM module_meeting_attendees a
             LEFT JOIN users u ON a.attendee_user_id = u.id
             LEFT JOIN person p ON u.id = p.user_id
             WHERE a.meeting_id = ?
             ORDER BY name'
        );
        $rosterStmt->execute([$meeting_id]);
        $attendees = $rosterStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'attendees' => $attendees]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
            'attendees' => []
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Invalid request',
    'attendees' => []
]);
