<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_once '../../../includes/helpers.php';
require_permission('feedback', 'save');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }

  $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
  $title = strip_tags(trim($_POST['title'] ?? ''));
  $description = strip_tags(trim($_POST['description'] ?? ''));
  $type = filter_var($_POST['type'] ?? null, FILTER_VALIDATE_INT);

  $validTypes = array_column(get_lookup_items($pdo, 'FEEDBACK_TYPE'), 'id');

  if ($id === false || $title === '' || $type === false || !in_array($type, $validTypes)) {
    die('Invalid input');
  }

  $stmt = $pdo->prepare('SELECT title, description, type FROM module_feedback WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $existing = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    die('Feedback not found');
  }

  $updateStmt = $pdo->prepare('UPDATE module_feedback SET user_updated = :uid, title = :title, description = :description, type = :type WHERE id = :id');
  $updateStmt->execute([
    ':uid' => $this_user_id,
    ':title' => $title,
    ':description' => $description,
    ':type' => $type,
    ':id' => $id
  ]);

  admin_audit_log(
    $pdo,
    $this_user_id,
    'module_feedback',
    $id,
    'UPDATE',
    json_encode($existing),
    json_encode(['title' => $title, 'description' => $description, 'type' => $type]),
    'Updated feedback'
  );
}

header('Location: ../index.php?action=list');
exit;

