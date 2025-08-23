<?php
require '../../../includes/php_header.php';
$id          = (int)($_POST['id'] ?? 0);
$project_id  = (int)($_POST['project_id'] ?? 0);
$question_id = (int)($_POST['question_id'] ?? 0);

if ($id && $project_id) {
  $sql = 'SELECT user_id, file_path, file_name FROM module_projects_files WHERE id = :id AND project_id = :pid';
  $params = [':id' => $id, ':pid' => $project_id];
  if ($question_id) {
    $sql .= ' AND question_id = :qid';
    $params[':qid'] = $question_id;
  }
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $file = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($file && ($is_admin || $file['user_id'] == $this_user_id)) {
    $pdo->prepare('DELETE FROM module_projects_files WHERE id = :id')->execute([':id' => $id]);
    $fullPath = dirname(__DIR__,3) . $file['file_path'];
    if (is_file($fullPath)) {
      unlink($fullPath);
    }
    admin_audit_log($pdo, $this_user_id, 'module_projects_files', $id, 'DELETE', json_encode(['file' => $file['file_name']]), '');
  }
}

$anchor = $question_id ? '#questions' : '';
header('Location: ../index.php?action=details&id=' . $project_id . $anchor);
exit;
