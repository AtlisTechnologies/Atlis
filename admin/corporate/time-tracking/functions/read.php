<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','read');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare('SELECT t.*, i.title AS invoice_title FROM module_time_tracking_entries t LEFT JOIN admin_finances_invoices i ON t.invoice_id = i.id WHERE t.id = :id');
  $stmt->execute([':id' => $id]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $stmt = $pdo->query('SELECT t.*, i.title AS invoice_title FROM module_time_tracking_entries t LEFT JOIN admin_finances_invoices i ON t.invoice_id = i.id');
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode(['success' => true, 'data' => $data]);
