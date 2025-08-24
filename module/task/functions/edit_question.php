<?php
require '../../../includes/php_header.php';

$question_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);
$question_text = trim($_POST['question_text'] ?? '');

if ($question_id && $task_id && $question_text !== '') {
  $stmt = $pdo->prepare('SELECT user_id, question_text FROM module_tasks_questions WHERE id = :id AND task_id = :tid');
  $stmt->execute([':id' => $question_id, ':tid' => $task_id]);
  $question = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($question && ($is_admin || (int)$question['user_id'] === (int)$this_user_id)) {
    $stmt = $pdo->prepare('UPDATE module_tasks_questions SET question_text = :question, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':question' => $question_text,
      ':uid' => $this_user_id,
      ':id' => $question_id
    ]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_questions', $question_id, 'UPDATE', $question['question_text'], $question_text);
  }
}

header('Location: ../index.php?action=details&id=' . $task_id . '#questions');
exit;
