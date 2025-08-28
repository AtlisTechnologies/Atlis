<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','unlink_invoice');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
if (!$id) {
  echo json_encode(['success' => false, 'error' => 'Missing id']);
  exit;
}

$stmt = $pdo->prepare('UPDATE admin_time_tracking_entries SET invoice_id = NULL, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
