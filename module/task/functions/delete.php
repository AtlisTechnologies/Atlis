<?php
require '../../../includes/php_header.php';
require_permission('task', 'delete');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id) {
    $stmt = $pdo->prepare('DELETE FROM module_tasks WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'DELETE', 'Deleted task');
  }
}

header('Location: ../index.php');
exit;

