<?php
require '../../../includes/php_header.php';
require_permission('agency','create|update');

if (!verify_csrf_token($_POST['csrf_token'] ?? null)) {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$id = (int)($_POST['id'] ?? 0);
if (!$id || empty($_FILES['file'])) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Missing data']);
    exit;
}

$file = $_FILES['file'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Upload error']);
    exit;
}

$maxMb = (int)get_system_property($pdo, 'AGENCY_FILE_MAX_UPLOAD_MB');
$maxSize = $maxMb ? $maxMb * 1024 * 1024 : 10 * 1024 * 1024;
$allowedMimeStr = get_system_property($pdo, 'AGENCY_FILE_ALLOWED_MIME') ?: 'image/jpeg,image/png,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,text/plain';
$allowedMimes = array_map('trim', explode(',', $allowedMimeStr));

if ($maxSize && $file['size'] > $maxSize) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'File too large']);
    exit;
}
if (!in_array($file['type'], $allowedMimes)) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid file type']);
    exit;
}

$uploadDir = dirname(__DIR__) . '/uploads/agency/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$baseName = basename($file['name']);
$safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
$targetName = 'agency_' . $id . '_' . time() . '_' . $safeName;
$targetPath = $uploadDir . $targetName;

if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    $filePathDb = '/module/agency/uploads/agency/' . $targetName;
    $stmt = $pdo->prepare('INSERT INTO module_agency_files (user_id,user_updated,agency_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:aid,:name,:path,:size,:type)');
    $stmt->execute([
        ':uid' => $this_user_id,
        ':aid' => $id,
        ':name' => $baseName,
        ':path' => $filePathDb,
        ':size' => $file['size'],
        ':type' => $file['type']
    ]);
    $fileId = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_agency_files', $fileId, 'UPLOAD', '', json_encode(['file' => $baseName]));

    header('Content-Type: application/json');
    echo json_encode(['file' => [
        'id' => $fileId,
        'name' => $baseName,
        'path' => $filePathDb,
        'size' => $file['size'],
        'type' => $file['type']
    ]]);
    exit;
}

http_response_code(500);
header('Content-Type: application/json');
echo json_encode(['error' => 'Upload failed']);
exit;

