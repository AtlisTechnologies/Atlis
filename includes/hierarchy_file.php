<?php
/**
 * Handle hierarchy file upload for organization, agency, and division records.
 */
function handle_hierarchy_upload(PDO $pdo, string $type, int $id, array $file, int $uid, ?string $oldPath): void {
    if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return;
    }

    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize || !is_uploaded_file($file['tmp_name'])) {
        return;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf'
    ];

    if (!isset($allowed[$mime])) {
        return;
    }

    $ext = $allowed[$mime];
    $uploadDir = dirname(__DIR__) . '/module/agency/uploads/' . $type . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
    }

    if ($oldPath) {
        @unlink($uploadDir . $oldPath);
    }

    $randomName = bin2hex(random_bytes(16)) . '.' . $ext;
    $dest = $uploadDir . $randomName;
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        return;
    }

    $stmt = $pdo->prepare("UPDATE module_{$type} SET file_name=?, file_path=?, file_size=?, file_type=? WHERE id=?");
    $stmt->execute([$file['name'], $randomName, (int)$file['size'], $mime, $id]);

    admin_audit_log($pdo, $uid, "module_{$type}", $id, 'UPLOAD', null, json_encode([
        'file_name' => $file['name'],
        'file_path' => $randomName,
        'file_size' => (int)$file['size'],
        'file_type' => $mime
    ]), 'Uploaded ' . $type . ' file');
}
