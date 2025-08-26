<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$data = $method === 'POST' ? $_POST : $_GET;
$meeting_id = (int)($data['meeting_id'] ?? 0);

if (!verify_csrf_token($data['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

if ($meeting_id) {
    $stmt = $pdo->prepare('SELECT id, meeting_id, agenda_id, question_text, answer_text, status_id FROM module_meeting_questions WHERE meeting_id = ? ORDER BY id');
    $stmt->execute([$meeting_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'questions' => $questions]);
    exit;
}

echo json_encode(['success' => false, 'questions' => []]);
