<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$description = trim($_POST['description'] ?? '');
$quantity = $_POST['quantity'] ?? null;
$rate = $_POST['rate'] ?? null;
$amount = $_POST['amount'] ?? null;
$time_entry_id = $_POST['time_entry_id'] ?? null;

if(!$id || $description===''){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE admin_finances_invoice_items SET description=:desc, quantity=:qty, rate=:rate, amount=:amt, time_entry_id=:teid, user_updated=:uid WHERE id=:id');
$stmt->execute([
  ':desc'=>$description,
  ':qty'=>$quantity,
  ':rate'=>$rate,
  ':amt'=>$amount,
  ':teid'=>$time_entry_id,
  ':uid'=>$this_user_id,
  ':id'=>$id
]);

echo json_encode(['success'=>true]);
