<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','delete');
require_once __DIR__ . '/utils.php';
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
if(!$id){
  echo json_encode(['success'=>false,'error'=>'Missing id']);
  exit;
}

$invStmt = $pdo->prepare('SELECT invoice_id FROM admin_finances_invoice_items WHERE id=:id');
$invStmt->execute([':id'=>$id]);
$invoice_id = $invStmt->fetchColumn();

$stmt = $pdo->prepare('DELETE FROM admin_finances_invoice_items WHERE id=:id');
$stmt->execute([':id'=>$id]);

if($invoice_id){
  recalc_invoice_total($pdo,(int)$invoice_id,$this_user_id);
}

echo json_encode(['success'=>true]);
