<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','link_invoice');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;
if (!$id || !$invoice_id) {
  echo json_encode(['success' => false, 'error' => 'Missing fields']);
  exit;
}

$stmt = $pdo->prepare('UPDATE admin_time_tracking_entries SET invoice_id = :invoice_id, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':invoice_id' => $invoice_id,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
