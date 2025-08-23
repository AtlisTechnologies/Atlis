<?php
if (!isset($pdo)) {
  require '../../includes/php_header.php';
}
require_once '../../includes/helpers.php';
require_permission('feedback', 'save');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }

  $title = strip_tags(trim($_POST['title'] ?? ''));
  $description = strip_tags(trim($_POST['description'] ?? ''));
  $type = filter_var($_POST['type'] ?? null, FILTER_VALIDATE_INT);

  $validTypes = array_column(get_lookup_items($pdo, 'FEEDBACK_TYPE'), 'id');

  if ($title === '' || $type === false || !in_array($type, $validTypes)) {
    die('Invalid input');
  }

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

header('Location: ../feedback/');
exit;
