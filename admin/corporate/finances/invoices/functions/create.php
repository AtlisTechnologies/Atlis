<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','create');
header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$amount = $_POST['amount'] ?? null;

if ($title === '') {
  echo json_encode(['success' => false, 'error' => 'Missing title']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO module_finances_invoices (user_id, title, amount) VALUES (:uid, :title, :amount)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':title' => $title,
  ':amount' => $amount
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
