<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);

    if ($id && $meeting_id) {
        $pdo->prepare('DELETE FROM module_meeting_attendees WHERE id=:id AND meeting_id=:mid')->execute([':id' => $id, ':mid' => $meeting_id]);
       admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $id, 'DELETE', 'Removed attendee');
    }

    $rosterStmt = $pdo->prepare('SELECT a.id, a.attendee_user_id, a.role, a.check_in_time, a.check_out_time, CONCAT(u.first_name, " ", u.last_name) AS name FROM module_meeting_attendees a LEFT JOIN users u ON a.attendee_user_id = u.id WHERE a.meeting_id = ? ORDER BY a.id');
    $rosterStmt->execute([$meeting_id]);
    $attendees = $rosterStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'attendees' => $attendees]);
    exit;
}

echo json_encode(['success' => false]);
