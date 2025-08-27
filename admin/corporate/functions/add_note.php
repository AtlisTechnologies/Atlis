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

$cid = (int)($_POST['corporate_id'] ?? 0);
$note = trim($_POST['note_text'] ?? '');
if (!$cid || $note === '') {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

try {
  $stmt = $pdo->prepare('INSERT INTO module_corporate_notes (corporate_id, note_text, user_id, user_updated) VALUES (:cid,:note,:uid,:uid)');
  $stmt->execute([':cid'=>$cid, ':note'=>$note, ':uid'=>$this_user_id]);
  $nid = (int)$pdo->lastInsertId();
} catch (PDOException $e) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate_notes',$nid,'NOTE',null,$note,'Added note');

header('Content-Type: application/json');
$noteData = ['id'=>$nid,'note_text'=>$note];
echo json_encode(['success'=>true,'note'=>$noteData]);
exit;
