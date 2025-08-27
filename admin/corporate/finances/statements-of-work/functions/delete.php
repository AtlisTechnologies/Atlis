<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','delete');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
if (!$id) {
  echo json_encode(['success' => false, 'error' => 'Missing id']);
  exit;
}

$stmt = $pdo->prepare('DELETE FROM module_finances_statements_of_work WHERE id = :id');
$stmt->execute([':id' => $id]);

echo json_encode(['success' => true]);
