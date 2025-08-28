<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','create');
header('Content-Type: application/json');

$invoice_number = trim($_POST['invoice_number'] ?? '');
$status_id = $_POST['status_id'] ?? null;
$bill_to = trim($_POST['bill_to'] ?? '');
$invoice_date = $_POST['invoice_date'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$total_amount = $_POST['total_amount'] ?? null;
$corporate_id = $_POST['corporate_id'] ?? 1;

$file_name = null;
$file_path = null;
$file_size = null;
$file_type = null;

if ($invoice_number === '') {
  echo json_encode(['success' => false, 'error' => 'Missing invoice number']);
  exit;
}

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

$stmt = $pdo->prepare('INSERT INTO admin_finances_invoices (user_id, corporate_id, invoice_number, status_id, bill_to, invoice_date, due_date, total_amount, file_name, file_path, file_size, file_type) VALUES (:uid, :cid, :invoice_number, :status_id, :bill_to, :invoice_date, :due_date, :total_amount, :fname, :fpath, :fsize, :ftype)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':cid' => $corporate_id,
  ':invoice_number' => $invoice_number,
  ':status_id' => $status_id,
  ':bill_to' => $bill_to,
  ':invoice_date' => $invoice_date,
  ':due_date' => $due_date,
  ':total_amount' => $total_amount,
  ':fname' => $file_name,
  ':fpath' => $file_path,
  ':fsize' => $file_size,
  ':ftype' => $file_type
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
