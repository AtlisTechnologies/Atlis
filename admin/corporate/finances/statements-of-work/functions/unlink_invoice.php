<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','update');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  echo json_encode(['success'=>false,'error'=>'Invalid request method']);
  exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$statement_id = $_POST['statement_id'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;
if(!$statement_id || !$invoice_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$sCorp = $pdo->prepare('SELECT corporate_id FROM admin_finances_statements_of_work WHERE id=:sid');
$sCorp->execute([':sid'=>$statement_id]);
$sowCorp = $sCorp->fetchColumn();
$iCorp = $pdo->prepare('SELECT corporate_id FROM admin_finances_invoices WHERE id=:iid');
$iCorp->execute([':iid'=>$invoice_id]);
$invCorp = $iCorp->fetchColumn();
if(!$sowCorp || !$invCorp || $sowCorp != $invCorp){
  echo json_encode(['success'=>false,'error'=>'Corporate mismatch']);
  exit;
}

$del = $pdo->prepare('DELETE FROM admin_finances_invoice_sow WHERE invoice_id=:iid AND statement_id=:sid');
$del->execute([':iid'=>$invoice_id,':sid'=>$statement_id]);

echo json_encode(['success'=>true]);
