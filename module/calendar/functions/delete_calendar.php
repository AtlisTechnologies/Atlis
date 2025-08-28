<?php
require '../../../includes/php_header.php';
require_permission('calendar','delete');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);

if (!$id) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Invalid calendar ID']);
  exit;
}

$chk = $pdo->prepare('SELECT user_id, is_default FROM module_calendar WHERE id = ?');
$chk->execute([$id]);

$existing = $chk->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  http_response_code(404);
  echo json_encode(['success' => false, 'error' => 'Calendar not found']);
  exit;
}

if ($existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
  // Calendar deletions are limited to the owner; Admins may override.
  http_response_code(403);
  echo json_encode(['success' => false, 'error' => 'Only the owner or an admin can delete this calendar']);
  exit;
}

if (!empty($existing['is_default'])) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Cannot delete default calendar']);
  exit;
}

$stmt = $pdo->prepare('DELETE FROM module_calendar WHERE id = ? AND is_default = 0');
$stmt->execute([$id]);
echo json_encode(['success' => true]);

