<?php
require '../../../includes/php_header.php';
require_permission('task','create|update|delete');

$task_id = (int)($_POST['task_id'] ?? 0);
$question = trim($_POST['question_text'] ?? '');
if ($task_id && $question !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_tasks_questions (user_id,user_updated,task_id,question_text) VALUES (:uid,:uid,:tid,:question)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':tid' => $task_id,
    ':question' => $question
  ]);
  $questionId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_tasks_questions',$questionId,'QUESTION','',$question);
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
