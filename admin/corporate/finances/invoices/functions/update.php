<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$invoice_number = trim($_POST['invoice_number'] ?? '');
$status_id = $_POST['status_id'] ?? null;
$bill_to = trim($_POST['bill_to'] ?? '');
$invoice_date = $_POST['invoice_date'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$total_amount = $_POST['total_amount'] ?? null;

if (!$id || $invoice_number === '') {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE admin_finances_invoices SET invoice_number = :invoice_number, status_id = :status_id, bill_to = :bill_to, invoice_date = :invoice_date, due_date = :due_date, total_amount = :total_amount, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':invoice_number' => $invoice_number,
  ':status_id' => $status_id,
  ':bill_to' => $bill_to,
  ':invoice_date' => $invoice_date,
  ':due_date' => $due_date,
  ':total_amount' => $total_amount,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
