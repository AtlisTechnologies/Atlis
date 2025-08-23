<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('feedback', 'save');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'] ?? '';
  $description = $_POST['description'] ?? '';
  $type = $_POST['type'] ?? null;

  $stmt = $pdo->prepare('INSERT INTO module_feedback (user_id, user_updated, title, description, type) VALUES (:uid, :uid, :title, :description, :type)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':title' => $title,
    ':description' => $description,
    ':type' => $type
  ]);
  $id = $pdo->lastInsertId();

  admin_audit_log(
    $pdo,
    $this_user_id,
    'module_feedback',
    $id,
    'CREATE',
    null,
    json_encode(['title' => $title, 'description' => $description, 'type' => $type]),
    'Created feedback'
  );
}

header('Location: ../index.php?action=list');
exit;
