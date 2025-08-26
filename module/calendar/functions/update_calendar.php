<?php
require '../../../includes/php_header.php';
require_permission('calendar','update');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$is_private = !empty($_POST['is_private']) ? 1 : 0;

if ($id && $name !== '') {
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
  $stmt = $pdo->prepare('UPDATE module_calendar SET name=?, is_private=?, user_updated=? WHERE id=?');
  $stmt->execute([$name, $is_private, $this_user_id, $id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

