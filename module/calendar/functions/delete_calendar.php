<?php
require '../../../includes/php_header.php';
require_permission('calendar','delete');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);

if ($id) {
  $chk = $pdo->prepare('SELECT user_id FROM module_calendar WHERE id = ?');
  $chk->execute([$id]);
  $owner = $chk->fetchColumn();
  if (!$owner) {
    echo json_encode(['success' => false]);
    exit;
  }
  if ($owner != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }
  $stmt = $pdo->prepare('DELETE FROM module_calendar WHERE id = ?');
  $stmt->execute([$id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

