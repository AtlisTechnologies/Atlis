<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/php_header.php';
require_permission('users','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Method not allowed']);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid CSRF token']);
  exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id || empty($_FILES['profile_pic']['name'])) {
  http_response_code(400);
  echo json_encode(['error' => 'Missing data']);
  exit;
}

function get_status_id(PDO $pdo, string $code): int {
  $stmt = $pdo->prepare("SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'USER_PROFILE_PIC_STATUS' AND li.code = :code LIMIT 1");
  $stmt->execute([':code' => $code]);
  return (int)$stmt->fetchColumn();
}

$activeStatusId = get_status_id($pdo, 'ACTIVE');
$inactiveStatusId = get_status_id($pdo, 'INACTIVE');
if (!$activeStatusId || !$inactiveStatusId) {
  http_response_code(500);
  echo json_encode(['error' => 'Profile picture status not configured']);
  exit;
}

$file = $_FILES['profile_pic'];
if ($file['error'] !== UPLOAD_ERR_OK) {
  http_response_code(400);
  echo json_encode(['error' => 'Upload error']);
  exit;
}
if ($file['size'] > 10 * 1024 * 1024) {
  http_response_code(400);
  echo json_encode(['error' => 'File too large']);
  exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);
$typeItems = get_lookup_items($pdo, 'IMAGE_FILE_TYPES');
$allowed = array_column($typeItems, 'code');
$extMap = array_column($typeItems, 'label', 'code');
if (!in_array($mime, $allowed, true)) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid file type']);
  exit;
}
$ext = $extMap[$mime] ?? pathinfo($file['name'], PATHINFO_EXTENSION);
$safe = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($file['name'], PATHINFO_FILENAME));
$filename = $safe . '_' . time() . '.' . $ext;
$destDir = '../../../module/users/uploads/';
if (!is_dir($destDir)) {
  mkdir($destDir, 0755, true);
}
$dest = $destDir . $filename;
if (!move_uploaded_file($file['tmp_name'], $dest)) {
  http_response_code(500);
  echo json_encode(['error' => 'Failed to save file']);
  exit;
}
$profilePath = 'module/users/uploads/' . $filename;
$fileSize = $file['size'];
$hashFile = hash_file('sha256', $dest);
$img = getimagesize($dest);
$width = $img ? $img[0] : null;
$height = $img ? $img[1] : null;

try {
  $pdo->beginTransaction();
  $pdo->prepare('UPDATE users_profile_pics SET status_id = :inactive, user_updated = :uid WHERE user_id = :user AND status_id = :active')
      ->execute([':inactive' => $inactiveStatusId, ':uid' => $this_user_id, ':user' => $id, ':active' => $activeStatusId]);
  $pstmt = $pdo->prepare('INSERT INTO users_profile_pics (user_id, uploaded_by, file_name, file_path, file_size, file_type, width, height, file_hash, status_id, user_updated) VALUES (:user_id, :uploaded_by, :file_name, :file_path, :file_size, :file_type, :width, :height, :file_hash, :status_id, :uid)');
  $pstmt->execute([
    ':user_id' => $id,
    ':uploaded_by' => $this_user_id,
    ':file_name' => $filename,
    ':file_path' => $profilePath,
    ':file_size' => $fileSize,
    ':file_type' => $mime,
    ':width' => $width,
    ':height' => $height,
    ':file_hash' => $hashFile,
    ':status_id' => $activeStatusId,
    ':uid' => $this_user_id
  ]);
  $picId = (int)$pdo->lastInsertId();
  $pdo->prepare('UPDATE users SET current_profile_pic_id = :pic, user_updated = :uid WHERE id = :user')
      ->execute([':pic' => $picId, ':uid' => $this_user_id, ':user' => $id]);
  $pdo->commit();
  echo json_encode(['success' => true, 'path' => $profilePath]);
} catch (Exception $e) {
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }
  error_log($e->getMessage());
  http_response_code(500);
  echo json_encode(['error' => 'Server error']);
}
