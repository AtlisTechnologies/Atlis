<?php
require '../../../includes/php_header.php';

$file_id    = (int)($_POST['id'] ?? 0);
$task_id    = (int)($_POST['task_id'] ?? 0);
$question_id = (int)($_POST['question_id'] ?? 0);
if ($file_id && $task_id) {
  $sql = 'SELECT user_id, file_path, file_name FROM module_tasks_files WHERE id = :id AND task_id = :tid';
  $params = [':id' => $file_id, ':tid' => $task_id];
  if ($question_id) {
    $sql .= ' AND question_id = :qid';
    $params[':qid'] = $question_id;
  }
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $file = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($file && ($is_admin || (int)$file['user_id'] === (int)$this_user_id)) {
    $pdo->prepare('DELETE FROM module_tasks_files WHERE id = :id')->execute([':id' => $file_id]);
    $fullPath = __DIR__ . '/../../..' . $file['file_path'];
    if (is_file($fullPath)) {
      unlink($fullPath);
    }
    admin_audit_log($pdo, $this_user_id, 'module_tasks_files', $file_id, 'DELETE', '', json_encode(['file' => $file['file_name']]));
  }
}
$anchor = $question_id ? '#questions' : '';
header('Location: ../index.php?action=details&id=' . $task_id . $anchor);
exit;
