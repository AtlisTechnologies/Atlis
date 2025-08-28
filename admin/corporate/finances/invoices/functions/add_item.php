<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
require_once __DIR__ . '/utils.php';
header('Content-Type: application/json');

$invoice_id = $_POST['invoice_id'] ?? null;
$description = trim($_POST['description'] ?? '');
$quantity = $_POST['quantity'] ?? null;
$rate = $_POST['rate'] ?? null;
$amount = $_POST['amount'] ?? null;
$time_entry_id = $_POST['time_entry_id'] ?? null;

if(!$invoice_id || $description===''){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO admin_finances_invoice_items (user_id,user_updated,invoice_id,description,quantity,rate,amount,time_entry_id) VALUES (:uid,:uid,:iid,:desc,:qty,:rate,:amt,:teid)');
$stmt->execute([
  ':uid'=>$this_user_id,
  ':iid'=>$invoice_id,
  ':desc'=>$description,
  ':qty'=>$quantity,
  ':rate'=>$rate,
  ':amt'=>$amount,
  ':teid'=>$time_entry_id
]);

recalc_invoice_total($pdo, (int)$invoice_id, $this_user_id);

echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
