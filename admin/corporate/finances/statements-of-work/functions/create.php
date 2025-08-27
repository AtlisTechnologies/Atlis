<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','create');
header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$details = $_POST['details'] ?? null;

if ($title === '') {
  echo json_encode(['success' => false, 'error' => 'Missing title']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO admin_finances_statements_of_work (user_id, title, details) VALUES (:uid, :title, :details)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':title' => $title,
  ':details' => $details
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
