<?php
require '../../../includes/php_header.php';
require_permission('calendar','update');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$is_private = !empty($_POST['is_private']) ? 1 : 0;

if ($id && $name !== '') {
  $chk = $pdo->prepare('SELECT user_id, is_default FROM module_calendar WHERE id = ?');
  $chk->execute([$id]);

  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }
  if ($existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    // Calendar updates are restricted to the owner unless the user is an Admin.

    http_response_code(403);
    exit;
  }
  $dup = $pdo->prepare('SELECT id FROM module_calendar WHERE user_id = ? AND name = ? AND id != ? LIMIT 1');
  $dup->execute([$existing['user_id'], $name, $id]);
  if ($dup->fetchColumn()) {
    echo json_encode(['success' => false, 'error' => 'Calendar name already exists']);
    exit;
  }
  if (!empty($existing['is_default']) && $is_private) {
    echo json_encode(['success' => false, 'error' => 'Default calendar cannot be private']);
    exit;
  }
  if (!empty($existing['is_default'])) {
    $is_private = 0;
  }
  $stmt = $pdo->prepare('UPDATE module_calendar SET name=?, is_private=?, user_updated=? WHERE id=?');
  $stmt->execute([$name, $is_private, $this_user_id, $id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

