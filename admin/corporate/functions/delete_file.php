<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('corporate','delete');

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
if (!$id) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>'Missing ID']);
  exit;
}

try {
  $stmt = $pdo->prepare('SELECT file_path FROM module_corporate_files WHERE id=:id');
  $stmt->execute([':id'=>$id]);
  $file = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($file) {
    $pdo->prepare('DELETE FROM module_corporate_files WHERE id=:id')->execute([':id'=>$id]);
    @unlink(__DIR__ . '/../../..//' . $file['file_path']);
  }
} catch (PDOException $e) {
  header('Content-Type: application/json');
  echo json_encode(['success'=>false,'error'=>$e->getMessage()]);
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_corporate_files',$id,'DELETE',null,null,'Deleted file');

header('Content-Type: application/json');
echo json_encode(['success'=>true]);
exit;
