<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
            throw new Exception('Invalid CSRF token');
        }

        $id = (int)($_POST['id'] ?? 0);
        $meeting_id = (int)($_POST['meeting_id'] ?? 0);
        if (!$id || !$meeting_id) {
            throw new Exception('Invalid request');
        }

        $pdo->prepare('DELETE FROM module_meeting_attendees WHERE id=:id AND meeting_id=:mid')
            ->execute([':id' => $id, ':mid' => $meeting_id]);
        admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $id, 'DELETE', '', '', 'Removed attendee');

        $rosterStmt = $pdo->prepare(
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
        $rosterStmt->execute([$meeting_id]);
        $attendees = $rosterStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'attendees' => $attendees]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
