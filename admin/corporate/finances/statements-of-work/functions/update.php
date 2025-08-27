<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$details = $_POST['details'] ?? null;

if (!$id || $title === '') {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE module_finances_statements_of_work SET title = :title, details = :details, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':title' => $title,
  ':details' => $details,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
