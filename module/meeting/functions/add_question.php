<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $meeting_id = (int)($_POST['meeting_id'] ?? 0);
  $question = trim($_POST['question'] ?? '');
  $answer = trim($_POST['answer'] ?? '');
  $stmt = $pdo->prepare('INSERT INTO module_meeting_questions (user_id, user_updated, meeting_id, question, answer) VALUES (?,?,?,?,?)');
  $stmt->execute([$this_user_id, $this_user_id, $meeting_id, $question, $answer]);
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_meeting_questions', $id, 'CREATE', 'Added question');
  echo json_encode(['success'=>true,'item'=>['id'=>$id,'question'=>$question,'answer'=>$answer]]);
  exit;
}

echo json_encode(['success'=>false]);
