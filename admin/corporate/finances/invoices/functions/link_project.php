<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$invoice_id = $_POST['invoice_id'] ?? null;
$project_id = $_POST['project_id'] ?? null;
if(!$invoice_id || !$project_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('SELECT id FROM admin_finances_invoice_projects WHERE invoice_id=:iid AND project_id=:pid');
$stmt->execute([':iid'=>$invoice_id,':pid'=>$project_id]);
if(!$stmt->fetch()){
  $ins = $pdo->prepare('INSERT INTO admin_finances_invoice_projects (user_id,user_updated,invoice_id,project_id) VALUES (:uid,:uid,:iid,:pid)');
  $ins->execute([':uid'=>$this_user_id,':iid'=>$invoice_id,':pid'=>$project_id]);
}

echo json_encode(['success'=>true]);
