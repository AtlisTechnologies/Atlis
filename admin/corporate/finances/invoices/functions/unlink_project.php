<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
  echo json_encode(['success'=>false,'error'=>'Invalid request method']);
  exit;
}

if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$invoice_id = $_POST['invoice_id'] ?? null;
$project_id = $_POST['project_id'] ?? null;
if(!$invoice_id || !$project_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$del = $pdo->prepare('DELETE FROM admin_finances_invoice_projects WHERE invoice_id=:iid AND project_id=:pid');
$del->execute([':iid'=>$invoice_id,':pid'=>$project_id]);

echo json_encode(['success'=>true]);
