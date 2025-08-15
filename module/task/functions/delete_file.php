<?php
require '../../../includes/php_header.php';

$file_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);
if ($file_id && $task_id) {
  $stmt = $pdo->prepare('SELECT user_id, file_path, file_name FROM module_tasks_files WHERE id = :id AND task_id = :tid');
  $stmt->execute([':id' => $file_id, ':tid' => $task_id]);
  $file = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($file && (int)$file['user_id'] === (int)$this_user_id) {
    $pdo->prepare('DELETE FROM module_tasks_files WHERE id = :id')->execute([':id' => $file_id]);
    $fullPath = __DIR__ . '/../../..' . $file['file_path'];
    if (is_file($fullPath)) {
      unlink($fullPath);
    }
    admin_audit_log($pdo, $this_user_id, 'module_tasks_files', $file_id, 'DELETE', '', json_encode(['file' => $file['file_name']]));
  }
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
