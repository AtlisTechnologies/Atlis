<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);

    try {
        if ($id && $meeting_id) {
            $pdo->prepare('DELETE FROM module_meeting_questions WHERE id=:id AND meeting_id=:mid')->execute([':id' => $id, ':mid' => $meeting_id]);
            admin_audit_log($pdo, $this_user_id, 'module_meeting_questions', $id, 'DELETE', 'Deleted question');
        }

        $listStmt = $pdo->prepare('SELECT id, meeting_id, agenda_id, question_text, answer_text, status_id FROM module_meeting_questions WHERE meeting_id=? ORDER BY id');
        $listStmt->execute([$meeting_id]);
        $questions = $listStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'questions' => $questions]);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
