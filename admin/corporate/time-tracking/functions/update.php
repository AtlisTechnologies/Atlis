<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$description = trim($_POST['description'] ?? '');
$hours = $_POST['hours'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;

if (!$id || $description === '' || $hours === null) {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE module_time_tracking_entries SET description = :description, hours = :hours, invoice_id = :invoice_id, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':description' => $description,
  ':hours' => $hours,
  ':invoice_id' => $invoice_id ?: null,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
