<?php
require '../../../includes/php_header.php';
require_permission('calendar','delete');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);

if ($id) {
  $stmt = $pdo->prepare('DELETE FROM module_calendar WHERE id = ?');
  $stmt->execute([$id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);

