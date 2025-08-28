<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$status_id = $_POST['status_id'] ?? null;

if (!$id || $title === '') {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$curr = $pdo->prepare('SELECT file_name,file_path,file_size,file_type FROM admin_finances_statements_of_work WHERE id=:id');
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
    $file_path = 'admin/corporate/finances/statements-of-work/uploads/' . $targetName;
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
  }
}

$stmt = $pdo->prepare('UPDATE admin_finances_statements_of_work SET title=:title, description=:description, start_date=:start_date, end_date=:end_date, status_id=:status_id, file_name=:fname, file_path=:fpath, file_size=:fsize, file_type=:ftype, user_updated=:uid WHERE id=:id');
$stmt->execute([
  ':title' => $title,
  ':description' => $description,
  ':start_date' => $start_date,
  ':end_date' => $end_date,
  ':status_id' => $status_id,
  ':fname'=>$file_name,
  ':fpath'=>$file_path,
  ':fsize'=>$file_size,
  ':ftype'=>$file_type,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
