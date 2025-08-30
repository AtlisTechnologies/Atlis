<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_note','delete');

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

$id = (int)($_POST['id'] ?? ($_GET['id'] ?? 0));
if (!$id) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Invalid ID']);
    exit;
}

$oldStmt = $pdo->prepare('SELECT * FROM admin_minder_notes WHERE id = :id');
$oldStmt->execute([':id'=>$id]);
$old = $oldStmt->fetch(PDO::FETCH_ASSOC);

if (!$old) {
    http_response_code(404);
    echo json_encode(['success'=>false,'error'=>'Not found']);
    exit;
}

$fileStmt = $pdo->prepare('SELECT file_path FROM admin_minder_notes_files WHERE note_id = :id');
$fileStmt->execute([':id'=>$id]);
$files = $fileStmt->fetchAll(PDO::FETCH_COLUMN);
$rootDir = dirname(__DIR__, 4) . '/';
foreach ($files as $fp) {
    if ($fp) @unlink($rootDir . $fp);
}
$pdo->prepare('DELETE FROM admin_minder_notes_files WHERE note_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_notes_persons WHERE note_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_notes_contractors WHERE note_id = :id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM admin_minder_notes WHERE id = :id')->execute([':id'=>$id]);

admin_audit_log($pdo,$this_user_id,'admin_minder_notes',$id,'DELETE',json_encode($old),null);

echo json_encode(['success'=>true]);
