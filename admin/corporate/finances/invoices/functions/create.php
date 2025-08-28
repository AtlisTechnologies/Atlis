<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','create');
header('Content-Type: application/json');

$invoice_number = trim($_POST['invoice_number'] ?? '');
$status_id = $_POST['status_id'] ?? null;
$bill_to = trim($_POST['bill_to'] ?? '');
$invoice_date = $_POST['invoice_date'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$total_amount = $_POST['total_amount'] ?? null;
$corporate_id = $_POST['corporate_id'] ?? 1;

if ($invoice_number === '') {
  echo json_encode(['success' => false, 'error' => 'Missing invoice number']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO admin_finances_invoices (user_id, corporate_id, invoice_number, status_id, bill_to, invoice_date, due_date, total_amount) VALUES (:uid, :cid, :invoice_number, :status_id, :bill_to, :invoice_date, :due_date, :total_amount)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':cid' => $corporate_id,
  ':invoice_number' => $invoice_number,
  ':status_id' => $status_id,
  ':bill_to' => $bill_to,
  ':invoice_date' => $invoice_date,
  ':due_date' => $due_date,
  ':total_amount' => $total_amount
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
