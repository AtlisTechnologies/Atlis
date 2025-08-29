<?php
require '../../../includes/php_header.php';
if (!verify_csrf_token($_POST['csrf_token'] ?? $_GET['csrf_token'] ?? null)) { http_response_code(403); exit('Forbidden'); }

$question_id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);

if ($question_id && $project_id) {
  $stmt = $pdo->prepare('SELECT user_id, question_text FROM module_projects_questions WHERE id = :id AND project_id = :pid');
  $stmt->execute([':id' => $question_id, ':pid' => $project_id]);
  $question = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($question && ($is_admin || (int)$question['user_id'] === (int)$this_user_id)) {
    $stmtF = $pdo->prepare('SELECT id, file_path, file_name FROM module_projects_files WHERE question_id = :qid');
    $stmtF->execute([':qid' => $question_id]);
    $files = $stmtF->fetchAll(PDO::FETCH_ASSOC);
    foreach ($files as $file) {
      $pdo->prepare('DELETE FROM module_projects_files WHERE id = :id')->execute([':id' => $file['id']]);
      $fullPath = dirname(__DIR__,3) . $file['file_path'];
      if (is_file($fullPath)) {
        unlink($fullPath);
      }
      admin_audit_log($pdo, $this_user_id, 'module_projects_files', $file['id'], 'DELETE', '', json_encode(['file' => $file['file_name']]));
    }
    $stmtA = $pdo->prepare('SELECT id, answer_text FROM module_projects_answers WHERE question_id = :qid');
    $stmtA->execute([':qid' => $question_id]);
    $answers = $stmtA->fetchAll(PDO::FETCH_ASSOC);
    foreach ($answers as $ans) {
      $pdo->prepare('DELETE FROM module_projects_answers WHERE id = :id')->execute([':id' => $ans['id']]);
      admin_audit_log($pdo, $this_user_id, 'module_projects_answers', $ans['id'], 'DELETE', '', $ans['answer_text']);
    }
    $pdo->prepare('DELETE FROM module_projects_questions WHERE id = :id')->execute([':id' => $question_id]);
    admin_audit_log($pdo, $this_user_id, 'module_projects_questions', $question_id, 'DELETE', '', $question['question_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $project_id . '#questions');
exit;
