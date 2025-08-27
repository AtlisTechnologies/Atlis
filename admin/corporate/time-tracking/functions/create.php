<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','create');
header('Content-Type: application/json');

$description = trim($_POST['description'] ?? '');
$hours = $_POST['hours'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;

if ($description === '' || $hours === null) {
  echo json_encode(['success' => false, 'error' => 'Missing fields']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO module_time_tracking_entries (user_id, description, hours, invoice_id) VALUES (:uid, :description, :hours, :invoice_id)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':description' => $description,
  ':hours' => $hours,
  ':invoice_id' => $invoice_id ?: null
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
