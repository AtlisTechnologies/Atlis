<?php
require '../../../includes/php_header.php';
if (!verify_csrf_token($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null)) { http_response_code(403); exit('Forbidden'); }

$answer_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);

if ($answer_id && $task_id) {
  $stmt = $pdo->prepare('SELECT user_id, answer_text FROM module_tasks_answers WHERE id = :id');
  $stmt->execute([':id' => $answer_id]);
  $answer = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($answer && ($is_admin || (int)$answer['user_id'] === (int)$this_user_id)) {
    $pdo->prepare('DELETE FROM module_tasks_answers WHERE id = :id')->execute([':id' => $answer_id]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_answers', $answer_id, 'DELETE', '', $answer['answer_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $task_id . '#questions');
exit;
