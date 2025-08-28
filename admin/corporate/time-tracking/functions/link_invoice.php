<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','link_invoice');
require_once __DIR__ . '/../../finances/invoices/functions/utils.php';
header('Content-Type: application/json');

$ids = $_POST['ids'] ?? [];
$invoice_id = $_POST['invoice_id'] ?? null;
if(!is_array($ids)){$ids = [$ids];}
$ids = array_filter($ids);
if(!$invoice_id || empty($ids)){
  echo json_encode(['success'=>false,'error'=>'Missing fields']);
  exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$params = array_merge([$invoice_id,$this_user_id], $ids);
$stmt = $pdo->prepare("UPDATE admin_time_tracking_entries SET invoice_id = ?, user_updated = ? WHERE id IN ($placeholders)");
$stmt->execute($params);

recalc_invoice_total($pdo,(int)$invoice_id,$this_user_id);

echo json_encode(['success'=>true]);
