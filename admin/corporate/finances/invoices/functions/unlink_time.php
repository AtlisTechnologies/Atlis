<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
require_once __DIR__ . '/utils.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  echo json_encode(['success'=>false,'error'=>'Invalid request method']);
  exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$time_entry_id = $_POST['time_entry_id'] ?? null;
if(!$time_entry_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('SELECT invoice_id FROM admin_time_tracking_entries WHERE id=:tid');
$stmt->execute([':tid'=>$time_entry_id]);
$invoice_id = $stmt->fetchColumn();

$upd = $pdo->prepare('UPDATE admin_time_tracking_entries SET invoice_id=NULL, user_updated=:uid WHERE id=:tid');
$upd->execute([':uid'=>$this_user_id,':tid'=>$time_entry_id]);

if($invoice_id){
  recalc_invoice_total($pdo,(int)$invoice_id,$this_user_id);
}

echo json_encode(['success'=>true]);
