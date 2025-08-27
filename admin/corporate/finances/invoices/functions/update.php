<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$amount = $_POST['amount'] ?? null;

if (!$id || $title === '') {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE module_finances_invoices SET title = :title, amount = :amount, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':title' => $title,
  ':amount' => $amount,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
