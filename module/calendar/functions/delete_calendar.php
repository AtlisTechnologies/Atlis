<?php
require '../../../includes/php_header.php';
require_permission('calendar','delete');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);

if ($id) {
  $chk = $pdo->prepare('SELECT user_id, is_default, is_private FROM module_calendar WHERE id = ?');
  $chk->execute([$id]);

  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }
  if ($existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    // Calendar deletions are limited to the owner; Admins may override.

    http_response_code(403);
    exit;
  }
  if (!empty($existing['is_default']) || !empty($existing['is_private'])) {
    $error = !empty($existing['is_default'])
      ? 'Cannot delete default calendar'
      : 'Cannot delete private calendar';
    echo json_encode(['success' => false, 'error' => $error]);
    exit;
  }
  $stmt = $pdo->prepare('DELETE FROM module_calendar WHERE id = ? AND is_default = 0 AND is_private = 0');
  $stmt->execute([$id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

