<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('minder_reminder','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$reminder_id = isset($_POST['reminder_id']) ? (int)$_POST['reminder_id'] : 0;
if (!$reminder_id || empty($_FILES['file']['name'])) {
  die('Missing data');
}

$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
  die('Upload error');
}
if ($file['size'] > 10 * 1024 * 1024) {
  die('File too large');
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

$safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $safe . '_' . time() . '.' . $ext;
$destDir = __DIR__ . '/../../../assets/files/minder/reminders/';
if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
$dest = $destDir . $filename;
if (!move_uploaded_file($file['tmp_name'], $dest)) {
  die('Failed to save file');
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

header('Location: ../reminder.php?id=' . $reminder_id);
