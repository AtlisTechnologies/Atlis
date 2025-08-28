<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$name = trim($_POST['name'] ?? '');
$is_private = !empty($_POST['is_private']) ? 1 : 0;

if ($name !== '') {
  $countStmt = $pdo->prepare('SELECT COUNT(*) FROM module_calendar WHERE user_id = ?');
  $countStmt->execute([$this_user_id]);
  $calCount = (int)$countStmt->fetchColumn();

  if ($calCount === 0) {
    $is_private = 0;
    $is_default = 1;
  } else {
    $is_default = 0;
  }

  $stmt = $pdo->prepare('INSERT INTO module_calendar (user_id, name, is_private, is_default) VALUES (?,?,?,?)');
  $stmt->execute([$this_user_id, $name, $is_private, $is_default]);
  echo json_encode(['success' => true, 'id' => $pdo->lastInsertId(), 'is_default' => $is_default]);
  exit;
}

echo json_encode(['success' => false]);

