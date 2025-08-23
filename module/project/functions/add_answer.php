<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
$question_id = (int)($_POST['question_id'] ?? 0);
$answer_text = trim($_POST['answer_text'] ?? '');

if ($project_id && $question_id && $answer_text !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_projects_answers (user_id,user_updated,question_id,answer_text) VALUES (:uid,:uid,:qid,:answer)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':qid' => $question_id,
    ':answer' => $answer_text
  ]);
  $answerId = $pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_projects_answers', $answerId, 'ANSWER', '', $answer_text);
}

header('Location: ../index.php?action=details&id=' . $project_id . '#questions');
exit;
?>
