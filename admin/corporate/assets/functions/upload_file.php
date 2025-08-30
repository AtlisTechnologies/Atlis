<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('assets','update');

$asset_id = (int)($_POST['asset_id'] ?? 0);
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  http_response_code(403);
  echo 'Invalid token';
  exit;
}
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo 'Upload error';
  exit;
}
$uploadDir = __DIR__ . '/../../../assets/uploads/' . $asset_id . '/';
if (!is_dir($uploadDir)) { mkdir($uploadDir,0775,true); }
$filename = basename($_FILES['file']['name']);
$target = $uploadDir . $filename;
if (!move_uploaded_file($_FILES['file']['tmp_name'],$target)) {
  http_response_code(500);
  echo 'Save failed';
  exit;
}
$pdo->prepare('INSERT INTO module_asset_files (asset_id,file_path,user_id,user_updated) VALUES (:aid,:path,:uid,:uid)')->execute([':aid'=>$asset_id,':path'=>$filename,':uid'=>$this_user_id]);
admin_audit_log($pdo,$this_user_id,'module_asset_files',$pdo->lastInsertId(),'asset.upload',null,$filename,'Uploaded file');

echo 'ok';
?>
