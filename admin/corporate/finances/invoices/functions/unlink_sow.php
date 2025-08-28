<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$invoice_id = $_POST['invoice_id'] ?? null;
$statement_id = $_POST['statement_id'] ?? null;
if(!$invoice_id || !$statement_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$del = $pdo->prepare('DELETE FROM admin_finances_invoice_sow WHERE invoice_id=:iid AND statement_id=:sid');
$del->execute([':iid'=>$invoice_id,':sid'=>$statement_id]);

echo json_encode(['success'=>true]);
