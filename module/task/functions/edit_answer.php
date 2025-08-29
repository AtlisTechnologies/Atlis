<?php
require '../../../includes/php_header.php';
if (!verify_csrf_token($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null)) { http_response_code(403); exit('Forbidden'); }

$answer_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);
$answer_text = trim($_POST['answer_text'] ?? '');

if ($answer_id && $task_id && $answer_text !== '') {
  $stmt = $pdo->prepare('SELECT user_id, answer_text FROM module_tasks_answers WHERE id = :id');
  $stmt->execute([':id' => $answer_id]);
  $answer = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($answer && ($is_admin || (int)$answer['user_id'] === (int)$this_user_id)) {
    $stmt = $pdo->prepare('UPDATE module_tasks_answers SET answer_text = :answer, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':answer' => $answer_text,
      ':uid' => $this_user_id,
      ':id' => $answer_id
    ]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_answers', $answer_id, 'UPDATE', $answer['answer_text'], $answer_text);
  }
}

header('Location: ../index.php?action=details&id=' . $task_id . '#questions');
exit;
