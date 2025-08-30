<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_files', 'create');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

$strategyId = (int)($_POST['strategy_id'] ?? 0);
if (!$strategyId || empty($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
  echo json_encode(['success' => false, 'error' => 'Invalid data']);
  exit;
}

// ensure strategy exists
$chk = $pdo->prepare('SELECT id FROM module_strategy WHERE id = :id');
$chk->execute([':id'=>$strategyId]);
if(!$chk->fetchColumn()){
  echo json_encode(['success'=>false,'error'=>'Invalid strategy']);
  exit;
}

$uploadDir = __DIR__ . '/../uploads/';
if(!is_dir($uploadDir)){
  mkdir($uploadDir,0777,true);
}

// validate extension and size
$orig = $_FILES['file']['name'];
$ext  = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
$allowed = ['pdf','docx','xlsx','png','jpg','jpeg'];
if (!in_array($ext, $allowed, true)) {
  echo json_encode(['success' => false, 'error' => 'Invalid file type']);
  exit;
}
if ($_FILES['file']['size'] > 10 * 1024 * 1024) {
  echo json_encode(['success' => false, 'error' => 'File too large']);
  exit;
}

$safe = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($orig));
$targetName = 'strategy_' . $strategyId . '_' . time() . '_' . $safe;
$targetPath = $uploadDir . $targetName;

if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
  echo json_encode(['success' => false, 'error' => 'Upload failed']);
  exit;
}

$dbPath = 'admin/corporate/strategy/uploads/' . $targetName;

$stmt = $pdo->prepare('INSERT INTO module_strategy_files (user_id,user_updated,strategy_id,file_name,file_path) VALUES (:uid,:uid,:sid,:name,:path)');
$stmt->execute([
  ':uid'=>$this_user_id,
  ':sid'=>$strategyId,
  ':name'=>$orig,
  ':path'=>$dbPath
]);
$fileId = (int)$pdo->lastInsertId();
admin_audit_log($pdo,$this_user_id,'module_strategy_files',$fileId,'UPLOAD','',json_encode(['file'=>$orig]));
echo json_encode(['success'=>true,'file'=>['id'=>$fileId,'file_name'=>$orig,'file_path'=>getURLDir() . $dbPath]]);
