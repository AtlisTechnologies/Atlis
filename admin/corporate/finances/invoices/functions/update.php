<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$invoice_number = trim($_POST['invoice_number'] ?? '');
$status_id = $_POST['status_id'] ?? null;
$bill_to = trim($_POST['bill_to'] ?? '');
$invoice_date = $_POST['invoice_date'] ?? null;
$period_start = $_POST['period_start'] ?? null;
$period_end = $_POST['period_end'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$total_amount = $_POST['total_amount'] ?? null;
$agency_id = $_POST['agency_id'] ?? null;
$division_id = $_POST['division_id'] ?? null;

if (!$id || $invoice_number === '') {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$curr = $pdo->prepare('SELECT file_name,file_path,file_size,file_type FROM admin_finances_invoices WHERE id=:id');
$curr->execute([':id'=>$id]);
$existing = $curr->fetch(PDO::FETCH_ASSOC);
$file_name = $existing['file_name'] ?? null;
$file_path = $existing['file_path'] ?? null;
$file_size = $existing['file_size'] ?? null;
$file_type = $existing['file_type'] ?? null;

if(!empty($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK){
  $uploadDir = __DIR__ . '/../uploads/';
  if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
  }
  $orig = $_FILES['file']['name'];
  $safe = preg_replace('/[^A-Za-z0-9._-]/','_', basename($orig));
  $targetName = time() . '_' . $safe;
  $targetPath = $uploadDir . $targetName;
  if(move_uploaded_file($_FILES['file']['tmp_name'],$targetPath)){
    $file_name = $orig;
    $file_path = 'admin/corporate/finances/invoices/uploads/' . $targetName;
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
  }
}

$stmt = $pdo->prepare('UPDATE admin_finances_invoices SET invoice_number = :invoice_number, agency_id=:agency_id, division_id=:division_id, status_id = :status_id, bill_to = :bill_to, invoice_date = :invoice_date, period_start=:period_start, period_end=:period_end, due_date = :due_date, total_amount = :total_amount, file_name=:fname, file_path=:fpath, file_size=:fsize, file_type=:ftype, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':invoice_number' => $invoice_number,
  ':agency_id' => $agency_id,
  ':division_id' => $division_id,
  ':status_id' => $status_id,
  ':bill_to' => $bill_to,
  ':invoice_date' => $invoice_date,
  ':period_start' => $period_start,
  ':period_end' => $period_end,
  ':due_date' => $due_date,
  ':total_amount' => $total_amount,
  ':fname'=>$file_name,
  ':fpath'=>$file_path,
  ':fsize'=>$file_size,
  ':ftype'=>$file_type,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
