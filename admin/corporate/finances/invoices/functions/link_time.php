<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$invoice_id = $_POST['invoice_id'] ?? null;
$time_entry_id = $_POST['time_entry_id'] ?? null;
if(!$invoice_id || !$time_entry_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$upd = $pdo->prepare('UPDATE admin_time_tracking_entries SET invoice_id=:iid, user_updated=:uid WHERE id=:tid');
$upd->execute([':iid'=>$invoice_id,':uid'=>$this_user_id,':tid'=>$time_entry_id]);

echo json_encode(['success'=>true]);
