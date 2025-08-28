<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_files', 'delete');
header('Content-Type: application/json');
$fileId     = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);

if(!$fileId || !$strategyId){
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

$stmt = $pdo->prepare('SELECT file_path FROM module_strategy_files WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id'=>$fileId, ':sid'=>$strategyId]);
$path = $stmt->fetchColumn();
if(!$path){
  echo json_encode(['success'=>false,'error'=>'Invalid file']);
  exit;
}

$full = __DIR__ . '/../uploads/' . basename($path);
if(is_file($full)){
  unlink($full);
}

$pdo->prepare('DELETE FROM module_strategy_files WHERE id = :id')->execute([':id'=>$fileId]);
admin_audit_log($pdo,$this_user_id,'module_strategy_files',$fileId,'DELETE','', '');
echo json_encode(['success'=>true]);
