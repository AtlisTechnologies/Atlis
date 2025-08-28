<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','update');
require_once __DIR__ . '/../../finances/invoices/functions/utils.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  echo json_encode(['success'=>false,'error'=>'Invalid request method']);
  exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$ids = $_POST['ids'] ?? [];
if(!is_array($ids)){$ids = [$ids];}
$ids = array_filter($ids);
if(empty($ids)){
  echo json_encode(['success'=>false,'error'=>'Missing id']);
  exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT DISTINCT invoice_id FROM admin_time_tracking_entries WHERE id IN ($placeholders)");
$stmt->execute($ids);
$invIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

$upd = $pdo->prepare("UPDATE admin_time_tracking_entries SET invoice_id = NULL, user_updated = ? WHERE id IN ($placeholders)");
$upd->execute(array_merge([$this_user_id], $ids));

foreach($invIds as $iid){
  if($iid){ recalc_invoice_total($pdo,(int)$iid,$this_user_id); }
}

echo json_encode(['success'=>true]);
