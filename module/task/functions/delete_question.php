<?php
require '../../../includes/php_header.php';

$question_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);

if ($question_id && $task_id) {
  $stmt = $pdo->prepare('SELECT user_id, question_text FROM module_tasks_questions WHERE id = :id AND task_id = :tid');
  $stmt->execute([':id' => $question_id, ':tid' => $task_id]);
  $question = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($question && ($is_admin || (int)$question['user_id'] === (int)$this_user_id)) {
    $stmtF = $pdo->prepare('SELECT id, file_path, file_name FROM module_tasks_files WHERE question_id = :qid');
    $stmtF->execute([':qid' => $question_id]);
    $files = $stmtF->fetchAll(PDO::FETCH_ASSOC);
    foreach ($files as $file) {
      $pdo->prepare('DELETE FROM module_tasks_files WHERE id = :id')->execute([':id' => $file['id']]);
      $fullPath = __DIR__ . '/../../..' . $file['file_path'];
      if (is_file($fullPath)) {
        unlink($fullPath);
      }
      admin_audit_log($pdo, $this_user_id, 'module_tasks_files', $file['id'], 'DELETE', '', json_encode(['file' => $file['file_name']]));
    }
    $stmtA = $pdo->prepare('SELECT id, answer_text FROM module_tasks_answers WHERE question_id = :qid');
    $stmtA->execute([':qid' => $question_id]);
    $answers = $stmtA->fetchAll(PDO::FETCH_ASSOC);
    foreach ($answers as $ans) {
      $pdo->prepare('DELETE FROM module_tasks_answers WHERE id = :id')->execute([':id' => $ans['id']]);
      admin_audit_log($pdo, $this_user_id, 'module_tasks_answers', $ans['id'], 'DELETE', '', $ans['answer_text']);
    }
    $pdo->prepare('DELETE FROM module_tasks_questions WHERE id = :id')->execute([':id' => $question_id]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_questions', $question_id, 'DELETE', '', $question['question_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $task_id . '#questions');
exit;
