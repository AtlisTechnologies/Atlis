<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','read');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare('SELECT i.id, i.invoice_number, i.status_id, l.name AS status, i.bill_to, i.invoice_date, i.due_date, i.total_amount, i.file_name, i.file_path, i.file_size, i.file_type FROM admin_finances_invoices i LEFT JOIN lookup_list_items l ON i.status_id = l.id WHERE i.id = :id');
  $stmt->execute([':id' => $id]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $stmt = $pdo->query('SELECT i.id, i.invoice_number, i.status_id, l.name AS status, i.bill_to, i.invoice_date, i.due_date, i.total_amount, i.file_name, i.file_path, i.file_size, i.file_type FROM admin_finances_invoices i LEFT JOIN lookup_list_items l ON i.status_id = l.id');
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode(['success' => true, 'data' => $data]);
