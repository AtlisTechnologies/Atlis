<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
$question_text = trim($_POST['question_text'] ?? '');

if ($project_id && $question_text !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_projects_questions (user_id,user_updated,project_id,question_text) VALUES (:uid,:uid,:pid,:question)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':pid' => $project_id,
    ':question' => $question_text
  ]);
  $questionId = $pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_projects_questions', $questionId, 'QUESTION', '', $question_text);
}

header('Location: ../index.php?action=details&id=' . $project_id . '#questions');
exit;
?>
