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

        $meeting_id = (int)($_POST['meeting_id'] ?? 0);
        $attendee_person_id = (int)($_POST['attendee_person_id'] ?? 0);
        if (!$meeting_id || !$attendee_person_id) {
            throw new Exception('Invalid request');
        }

        // Find the row id for audit logging before deleting
        $idStmt = $pdo->prepare('SELECT id FROM module_meeting_attendees WHERE meeting_id = :mid AND attendee_person_id = :pid');
        $idStmt->execute([':mid' => $meeting_id, ':pid' => $attendee_person_id]);
        $row_id = $idStmt->fetchColumn();

        $pdo->prepare('DELETE FROM module_meeting_attendees WHERE meeting_id=:mid AND attendee_person_id=:pid')
            ->execute([':mid' => $meeting_id, ':pid' => $attendee_person_id]);

        if ($row_id) {
            admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $row_id, 'DELETE', '', '', 'Removed attendee');
        }

        $rosterStmt = $pdo->prepare(
            'SELECT a.id,
                    a.attendee_person_id,
                    a.attendee_user_id,
                    COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name
             FROM module_meeting_attendees a
             LEFT JOIN person p ON a.attendee_person_id = p.id
             LEFT JOIN users u ON p.user_id = u.id
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

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request']);
