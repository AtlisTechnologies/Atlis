<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_note','create');

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

$title = trim($_POST['title'] ?? '');
$body  = trim($_POST['body'] ?? '');
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
$status_id   = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;

if ($title === '' || $body === '') {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'Title and body required']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO admin_minder_notes (title, body, category_id, status_id, user_id, user_updated) VALUES (:title,:body,:category_id,:status_id,:uid,:uid)');
    $stmt->execute([
        ':title' => $title,
        ':body' => $body,
        ':category_id' => $category_id,
        ':status_id' => $status_id,
        ':uid' => $this_user_id
    ]);
    $id = (int)$pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'admin_minder_notes',$id,'CREATE',null,json_encode(['title'=>$title]));
    echo json_encode(['success'=>true,'id'=>$id]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
}
