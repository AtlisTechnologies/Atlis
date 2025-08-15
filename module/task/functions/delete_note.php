<?php
require '../../../includes/php_header.php';

$note_id = (int)($_POST['id'] ?? 0);
$task_id = (int)($_POST['task_id'] ?? 0);
if ($note_id && $task_id) {
  $stmt = $pdo->prepare('SELECT user_id, note_text FROM module_tasks_notes WHERE id = :id AND task_id = :tid');
  $stmt->execute([':id' => $note_id, ':tid' => $task_id]);
  $note = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($note && (int)$note['user_id'] === (int)$this_user_id) {
    $pdo->prepare('DELETE FROM module_tasks_notes WHERE id = :id')->execute([':id' => $note_id]);
    admin_audit_log($pdo, $this_user_id, 'module_tasks_notes', $note_id, 'DELETE', '', $note['note_text']);
  }
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
