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
$contractor_id = (int)($_POST['contractor_id'] ?? 0);
if (!$note_id || !$contractor_id) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Missing data']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO admin_minder_notes_contractor (note_id, contractor_id, user_id, user_updated) VALUES (:note,:contractor,:uid,:uid)');
    $stmt->execute([
        ':note' => $note_id,
        ':contractor' => $contractor_id,
        ':uid' => $this_user_id
    ]);
    $linkId = (int)$pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'admin_minder_notes_contractor',$linkId,'CREATE',null,json_encode(['contractor_id'=>$contractor_id]));
    echo json_encode(['success'=>true,'id'=>$linkId]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
