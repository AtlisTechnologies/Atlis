<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_reminder','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  http_response_code(403);
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$reminder_id = isset($_POST['reminder_id']) ? (int)$_POST['reminder_id'] : 0;
if (!$reminder_id || empty($_FILES['file']['name'])) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'Upload error']);
  exit;
}
if ($file['size'] > 10 * 1024 * 1024) {
  http_response_code(400);
  echo json_encode(['success'=>false,'error'=>'File too large']);
  exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $safe . '_' . time() . '.' . $ext;
$destDir = __DIR__ . '/../../../../assets/files/minder/reminders/';
if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
$dest = $destDir . $filename;
if (!move_uploaded_file($file['tmp_name'], $dest)) {
  http_response_code(500);
  echo json_encode(['success'=>false,'error'=>'Failed to save file']);
  exit;
}

$relPath = 'assets/files/minder/reminders/' . $filename;
$pdo->prepare('INSERT INTO admin_minder_reminders_files (reminder_id, file_name, file_path, file_size, file_type, user_id, user_updated) VALUES (:rid,:name,:path,:size,:type,:uid,:uid)')
    ->execute([
      ':rid' => $reminder_id,
      ':name' => $file['name'],
      ':path' => $relPath,
      ':size' => $file['size'],
      ':type' => $mime,
      ':uid' => $this_user_id
    ]);
$fileId = (int)$pdo->lastInsertId();

admin_audit_log($pdo, $this_user_id, 'admin_minder_reminders_files', $fileId, 'CREATE', null, json_encode(['file'=>$file['name']]), 'Uploaded file');

echo json_encode(['success'=>true,'file_id'=>$fileId,'name'=>$file['name'],'path'=>$relPath]);
exit;
