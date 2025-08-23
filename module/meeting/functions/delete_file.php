<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$meeting_id = (int)($_POST['meeting_id'] ?? 0);

if ($id && $meeting_id) {
    $stmt = $pdo->prepare('SELECT uploader_id, file_path, file_name FROM module_meeting_files WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($file && ($is_admin || $file['uploader_id'] == $this_user_id)) {
        $pdo->prepare('DELETE FROM module_meeting_files WHERE id = :id')->execute([':id' => $id]);
        $fullPath = dirname(__DIR__, 3) . $file['file_path'];
        if (is_file($fullPath)) {
            unlink($fullPath);
        }
        admin_audit_log($pdo, $this_user_id, 'module_meeting_files', $id, 'DELETE', json_encode(['file' => $file['file_name']]), '');
    }
}

$listStmt = $pdo->prepare('SELECT id, file_name, file_path, uploader_id FROM module_meeting_files WHERE meeting_id = ? ORDER BY id');
$listStmt->execute([$meeting_id]);
$rows = $listStmt->fetchAll(PDO::FETCH_ASSOC);
$files = [];
foreach ($rows as $r) {
    $files[] = [
        'id' => (int)$r['id'],
        'name' => $r['file_name'],
        'url' => getURLDir() . ltrim($r['file_path'], '/')
    ];
}

echo json_encode(['success' => true, 'files' => $files]);
exit;
