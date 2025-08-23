<?php
require '../../../includes/php_header.php';
require_permission('task','create|update|delete');

$task_id = (int)($_POST['task_id'] ?? 0);
$question_id = (int)($_POST['question_id'] ?? 0);
$answer = trim($_POST['answer_text'] ?? '');
if ($task_id && $question_id && $answer !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_tasks_answers (user_id,user_updated,question_id,answer_text) VALUES (:uid,:uid,:qid,:answer)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':qid' => $question_id,
    ':answer' => $answer
  ]);
  $answerId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_tasks_answers',$answerId,'ANSWER','',$answer);
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
