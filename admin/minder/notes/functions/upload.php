<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_note','update');

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

$note_id = (int)($_POST['note_id'] ?? 0);
if (!$note_id || empty($_FILES['file']['name'])) {
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
$ext  = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $safe . '_' . time() . '.' . $ext;
$destDir = dirname(__DIR__, 4) . '/assets/files/minder/notes/';
if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
$dest = $destDir . $filename;
if (!move_uploaded_file($file['tmp_name'], $dest)) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Failed to save file']);
    exit;
}

$relPath = 'assets/files/minder/notes/' . $filename;
try {
    $stmt = $pdo->prepare('INSERT INTO admin_minder_notes_files (note_id, file_name, file_path, file_size, file_type, user_id, user_updated) VALUES (:note_id,:name,:path,:size,:type,:uid,:uid)');
    $stmt->execute([
        ':note_id' => $note_id,
        ':name' => $file['name'],
        ':path' => $relPath,
        ':size' => $file['size'],
        ':type' => $mime,
        ':uid' => $this_user_id
    ]);
    $fid = (int)$pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'admin_minder_notes_files',$fid,'UPLOAD',null,json_encode(['file'=>$file['name']]));
    echo json_encode(['success'=>true,'id'=>$fid,'name'=>$file['name'],'path'=>$relPath]);
} catch (PDOException $e) {
    @unlink($dest);
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
