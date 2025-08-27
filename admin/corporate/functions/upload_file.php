<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','create');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  header('Content-Type: application/json');
  http_response_code(403);
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$cid = (int)($_POST['corporate_id'] ?? 0);
if (!$cid || empty($_FILES['file']['name'])) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Upload error']);
  exit;
}
if ($file['size'] > 10*1024*1024) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'File too large']);
  exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$safe = preg_replace('/[^a-zA-Z0-9_-]/','_',pathinfo($file['name'],PATHINFO_FILENAME));
$ext = pathinfo($file['name'],PATHINFO_EXTENSION);
$filename = $safe . '_' . time() . '.' . $ext;
$destDir = __DIR__ . '/../uploads/';
if (!is_dir($destDir)) { mkdir($destDir,0755,true); }
$dest = $destDir . $filename;
if (!move_uploaded_file($file['tmp_name'],$dest)) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Failed to save file']);
  exit;
}

$relPath = 'admin/corporate/uploads/' . $filename;
try {
  $pdo->prepare('INSERT INTO module_corporate_files (corporate_id, file_name, file_path, file_size, file_type, user_id, user_updated) VALUES (:cid,:name,:path,:size,:type,:uid,:uid)')
    ->execute([
      ':cid'=>$cid,
      ':name'=>$file['name'],
      ':path'=>$relPath,
      ':size'=>$file['size'],
      ':type'=>$mime,
      ':uid'=>$this_user_id
    ]);
  $fid = (int)$pdo->lastInsertId();
} catch (PDOException $e) {
  @unlink($dest);
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate_files',$fid,'CREATE',null,json_encode(['file'=>$file['name']]),'Uploaded file');

header('Content-Type: application/json');
$fileData = ['id'=>$fid,'file_name'=>$file['name'],'file_path'=>$relPath];
echo json_encode(['success'=>true,'file'=>$fileData]);
exit;
