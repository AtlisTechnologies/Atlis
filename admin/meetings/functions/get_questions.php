<?php
require '../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$meeting_id = (int)($_GET['meeting_id'] ?? 0);

if ($meeting_id) {
    $stmt = $pdo->prepare('SELECT id, agenda_id, question_text AS question, answer_text AS answer FROM module_meeting_questions WHERE meeting_id = ? ORDER BY id');
    $stmt->execute([$meeting_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'questions' => $questions]);
    exit;
}

echo json_encode(['success' => false, 'questions' => []]);
