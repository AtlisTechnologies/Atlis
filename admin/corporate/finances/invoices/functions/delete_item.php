<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','delete');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
if(!$id){
  echo json_encode(['success'=>false,'error'=>'Missing id']);
  exit;
}

$stmt = $pdo->prepare('DELETE FROM admin_finances_invoice_items WHERE id=:id');
$stmt->execute([':id'=>$id]);

echo json_encode(['success'=>true]);
