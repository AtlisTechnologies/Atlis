<?php
require '../../../includes/php_header.php';

$note_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);
if ($note_id && $task_id) {
  $stmt = $pdo->prepare('SELECT user_id, note_text FROM module_tasks_notes WHERE id = :id AND task_id = :tid');
  $stmt->execute([':id' => $note_id, ':tid' => $task_id]);
  $note = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($note && (int)$note['user_id'] === (int)$this_user_id) {
    $stmtFiles = $pdo->prepare('SELECT id, file_path, file_name FROM module_tasks_files WHERE note_id = :id');
    $stmtFiles->execute([':id' => $note_id]);
    $files = $stmtFiles->fetchAll(PDO::FETCH_ASSOC);
    foreach ($files as $file) {
      $pdo->prepare('DELETE FROM module_tasks_files WHERE id = :fid')->execute([':fid' => $file['id']]);
      $fullPath = __DIR__ . '/../../..' . $file['file_path'];
      if (is_file($fullPath)) {
        unlink($fullPath);
      }
      admin_audit_log($pdo, $this_user_id, 'module_tasks_files', $file['id'], 'DELETE', '', json_encode(['file' => $file['file_name']]));
    }
    $pdo->prepare('DELETE FROM module_tasks_notes WHERE id = :id')->execute([':id' => $note_id]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_notes', $note_id, 'DELETE', '', $note['note_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
