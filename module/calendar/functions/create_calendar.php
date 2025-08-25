<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$name = trim($_POST['name'] ?? '');
$is_private = !empty($_POST['is_private']) ? 1 : 0;

if ($name !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_calendar (user_id, name, is_private) VALUES (?,?,?)');
  $stmt->execute([$this_user_id, $name, $is_private]);
  echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
  exit;
}

echo json_encode(['success' => false]);

