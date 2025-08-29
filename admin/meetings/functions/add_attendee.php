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
        $attendee_person_id = isset($_POST['attendee_person_id']) && $_POST['attendee_person_id'] !== '' ? (int)$_POST['attendee_person_id'] : null;

        // Determine the attendee's user_id from the person record
        $attendee_user_id = null;
        if ($attendee_person_id) {
            $personStmt = $pdo->prepare('SELECT user_id FROM person WHERE id = ?');
            $personStmt->execute([$attendee_person_id]);
            $attendee_user_id = $personStmt->fetchColumn() ?: null;
        }

        if (!$meeting_id || !$attendee_person_id || !$attendee_user_id) {
            throw new Exception('Invalid request');
        }

        // Check for existing attendee before attempting to insert
        $checkStmt = $pdo->prepare('SELECT id FROM module_meeting_attendees WHERE meeting_id = ? AND attendee_user_id = ?');
        $checkStmt->execute([$meeting_id, $attendee_user_id]);
        if ($checkStmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Attendee already added']);
            exit;
        }

        $stmt = $pdo->prepare(
            'INSERT INTO module_meeting_attendees (
                user_id,
                user_updated,
                meeting_id,
                attendee_person_id,
                attendee_user_id
            ) VALUES (:uid,:uid,:mid,:person,:user)'
        );
        $stmt->execute([
            ':uid' => $this_user_id,
            ':mid' => $meeting_id,
            ':person' => $attendee_person_id,
            ':user' => $attendee_user_id
        ]);
        $id = $pdo->lastInsertId();
        admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $id, 'CREATE', '', json_encode(['person_id' => $attendee_person_id, 'user_id' => $attendee_user_id]), 'Added attendee');

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
