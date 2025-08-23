<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('feedback', 'delete');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id) {
    $stmt = $pdo->prepare('SELECT title, description, type FROM module_feedback WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existing) {
      $pdo->prepare('DELETE FROM module_feedback WHERE id = :id')->execute([':id' => $id]);
      admin_audit_log(
        $pdo,
        $this_user_id,
        'module_feedback',
        $id,
        'DELETE',
        json_encode($existing),
        '',
        'Deleted feedback'
      );
    }
  }
}

header('Location: ../index.php?action=list');
exit;
