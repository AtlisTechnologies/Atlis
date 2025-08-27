<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Content-Type: application/json');
  http_response_code(405);
  echo json_encode(['success'=>false,'error'=>'Method not allowed']);
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  header('Content-Type: application/json');
  http_response_code(403);
  echo json_encode(['success'=>false,'error'=>'Invalid CSRF token']);
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$note = trim($_POST['note_text'] ?? '');
if (!$id || $note === '') {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

try {
  $stmt = $pdo->prepare('UPDATE module_corporate_notes SET note_text=:note, user_updated=:uid WHERE id=:id');
  $stmt->execute([':note'=>$note, ':uid'=>$this_user_id, ':id'=>$id]);
} catch (PDOException $e) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate_notes',$id,'UPDATE',null,$note,'Updated note');

header('Content-Type: application/json');
echo json_encode(['success'=>true]);
exit;
