<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','create');
header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$status_id = $_POST['status_id'] ?? null;
$corporate_id = $_POST['corporate_id'] ?? 1;

$file_name = null;
$file_path = null;
$file_size = null;
$file_type = null;

if ($title === '') {
  echo json_encode(['success' => false, 'error' => 'Missing title']);
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
    $file_path = 'admin/corporate/finances/statements-of-work/uploads/' . $targetName;
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
  }
}

$stmt = $pdo->prepare('INSERT INTO admin_finances_statements_of_work (user_id, corporate_id, title, description, start_date, end_date, status_id, file_name, file_path, file_size, file_type) VALUES (:uid, :cid, :title, :description, :start_date, :end_date, :status_id, :fname, :fpath, :fsize, :ftype)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':cid' => $corporate_id,
  ':title' => $title,
  ':description' => $description,
  ':start_date' => $start_date,
  ':end_date' => $end_date,
  ':status_id' => $status_id,
  ':fname' => $file_name,
  ':fpath' => $file_path,
  ':fsize' => $file_size,
  ':ftype' => $file_type
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
