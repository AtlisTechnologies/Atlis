<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','update');
header('Content-Type: application/json');

$statement_id = $_POST['statement_id'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;
if(!$statement_id || !$invoice_id){
  echo json_encode(['success'=>false,'error'=>'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('SELECT id FROM admin_finances_invoice_sow WHERE invoice_id=:iid AND statement_id=:sid');
$stmt->execute([':iid'=>$invoice_id,':sid'=>$statement_id]);
if(!$stmt->fetch()){
  $ins = $pdo->prepare('INSERT INTO admin_finances_invoice_sow (user_id,user_updated,invoice_id,statement_id) VALUES (:uid,:uid,:iid,:sid)');
  $ins->execute([':uid'=>$this_user_id,':iid'=>$invoice_id,':sid'=>$statement_id]);
}

echo json_encode(['success'=>true]);
