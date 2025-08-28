<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_notes', 'delete');
header('Content-Type: application/json');
$noteId     = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);

if(!$noteId || !$strategyId){
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

// verify note belongs to strategy
$stmt = $pdo->prepare('SELECT id FROM module_strategy_notes WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id'=>$noteId, ':sid'=>$strategyId]);
if(!$stmt->fetchColumn()){
  echo json_encode(['success'=>false,'error'=>'Invalid note']);
  exit;
}

$pdo->prepare('DELETE FROM module_strategy_notes WHERE id = :id')->execute([':id'=>$noteId]);
admin_audit_log($pdo,$this_user_id,'module_strategy_notes',$noteId,'DELETE','', '');
echo json_encode(['success'=>true]);
