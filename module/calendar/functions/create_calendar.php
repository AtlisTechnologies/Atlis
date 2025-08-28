<?php
require '../../../includes/php_header.php';
require_permission('calendar','create');

header('Content-Type: application/json');

$name = trim($_POST['name'] ?? '');
$is_private = !empty($_POST['is_private']) ? 1 : 0;

if ($name !== '') {
  $dup = $pdo->prepare('SELECT id FROM module_calendar WHERE user_id = ? AND name = ? LIMIT 1');
  $dup->execute([$this_user_id, $name]);
  if ($dup->fetchColumn()) {
    echo json_encode(['success' => false, 'error' => 'Calendar name already exists']);
    exit;
  }

  $countStmt = $pdo->prepare('SELECT COUNT(*) FROM module_calendar WHERE user_id = ?');
  $countStmt->execute([$this_user_id]);
  $calCount = (int)$countStmt->fetchColumn();

  if ($calCount === 0) {
    $is_private = 0;
    $is_default = 1;
  } else {
    $is_default = 0;
  }

  $ics_token = bin2hex(random_bytes(16));
  $stmt = $pdo->prepare('INSERT INTO module_calendar (user_id, name, is_private, is_default, ics_token) VALUES (?,?,?,?,?)');
  $stmt->execute([$this_user_id, $name, $is_private, $is_default, $ics_token]);
  echo json_encode(['success' => true, 'id' => $pdo->lastInsertId(), 'is_default' => $is_default, 'ics_token' => $ics_token]);
  exit;
}

echo json_encode(['success' => false]);

