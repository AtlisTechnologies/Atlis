<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);

if ($id) {
  $chk = $pdo->prepare('SELECT user_id FROM module_calendar WHERE id = ?');
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
  $stmt = $pdo->prepare('DELETE FROM module_calendar WHERE id = ?');
  $stmt->execute([$id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

