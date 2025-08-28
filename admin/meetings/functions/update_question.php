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
    $agenda_id = isset($_POST['agenda_id']) && $_POST['agenda_id'] !== '' ? (int)$_POST['agenda_id'] : null;
    $question_text = trim($_POST['question_text'] ?? '');
    $answer_text = trim($_POST['answer_text'] ?? '');
    $status_id = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
    if ($status_id === null) {
        $defaultStatus = array_filter(
            get_lookup_items($pdo, 'MEETING_QUESTION_STATUS'),
            fn($i) => (!empty($i['is_default']) && $i['is_default'] == 1) || (!empty($i['default']) && $i['default'] == 1)
        );
        $status_id = $defaultStatus ? (int)array_values($defaultStatus)[0]['id'] : null;
    }

    try {
        if ($id && $meeting_id) {
            $stmt = $pdo->prepare('UPDATE module_meeting_questions SET user_updated=:uid, agenda_id=:aid, question_text=:q, answer_text=:a, status_id=:status WHERE id=:id AND meeting_id=:mid');
            $stmt->execute([
                ':uid' => $this_user_id,
                ':aid' => $agenda_id,
                ':q' => $question_text,
                ':a' => $answer_text,
                ':status' => $status_id,
                ':id' => $id,
                ':mid' => $meeting_id
            ]);
            admin_audit_log($pdo, $this_user_id, 'module_meeting_questions', $id, 'UPDATE', '', json_encode(['question'=>$question_text,'answer'=>$answer_text]), 'Updated question');
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
