<?php
require '../../../includes/php_header.php';

$answer_id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);

if ($answer_id && $project_id) {
  $stmt = $pdo->prepare('SELECT user_id, answer_text FROM module_projects_answers WHERE id = :id');
  $stmt->execute([':id' => $answer_id]);
  $answer = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($answer && ($is_admin || (int)$answer['user_id'] === (int)$this_user_id)) {
    $stmtF = $pdo->prepare('SELECT id, file_path, file_name FROM module_projects_files WHERE answer_id = :aid');
    $stmtF->execute([':aid' => $answer_id]);
    $files = $stmtF->fetchAll(PDO::FETCH_ASSOC);
    foreach ($files as $file) {
      $pdo->prepare('DELETE FROM module_projects_files WHERE id = :id')->execute([':id' => $file['id']]);
      $fullPath = dirname(__DIR__,3) . $file['file_path'];
      if (is_file($fullPath)) {
        unlink($fullPath);
      }
      admin_audit_log($pdo, $this_user_id, 'module_projects_files', $file['id'], 'DELETE', json_encode(['file' => $file['file_name']]), '');
    }
    $pdo->prepare('DELETE FROM module_projects_answers WHERE id = :id')->execute([':id' => $answer_id]);
    admin_audit_log($pdo, $this_user_id, 'module_projects_answers', $answer_id, 'DELETE', '', $answer['answer_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $project_id . '#questions');
exit;
