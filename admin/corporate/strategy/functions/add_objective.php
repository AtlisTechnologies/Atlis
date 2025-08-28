<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'create');
header('Content-Type: application/json');

$strategyId = (int)($_POST['strategy_id'] ?? 0);
$parentId = $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : null;
$objective = trim($_POST['objective'] ?? '');
$ownerId = $_POST['owner_id'] !== '' ? (int)$_POST['owner_id'] : null;

if(!$strategyId || $objective === ''){
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

// ensure parent belongs to same strategy if provided
if ($parentId) {
  $chk = $pdo->prepare('SELECT id FROM module_strategy_objectives WHERE id = :pid AND strategy_id = :sid');
  $chk->execute([':pid'=>$parentId, ':sid'=>$strategyId]);
  if(!$chk->fetchColumn()){
    echo json_encode(['success'=>false,'error'=>'Invalid parent objective']);
    exit;
  }
}

// determine sort order
$sortStmt = $pdo->prepare('SELECT COALESCE(MAX(sort_order),0)+1 FROM module_strategy_objectives WHERE strategy_id = :sid AND ((parent_id IS NULL AND :pid IS NULL) OR parent_id = :pid)');
$sortStmt->execute([':sid'=>$strategyId, ':pid'=>$parentId]);
$sort = (int)$sortStmt->fetchColumn();

$stmt = $pdo->prepare('INSERT INTO module_strategy_objectives (user_id,user_updated,strategy_id,parent_id,objective,owner_id,sort_order) VALUES (:uid,:uid,:sid,:pid,:obj,:owner,:sort)');
$stmt->execute([
  ':uid'=>$this_user_id,
  ':sid'=>$strategyId,
  ':pid'=>$parentId,
  ':obj'=>$objective,
  ':owner'=>$ownerId,
  ':sort'=>$sort
]);
$objectiveId = (int)$pdo->lastInsertId();
admin_audit_log($pdo,$this_user_id,'module_strategy_objectives',$objectiveId,'CREATE',null,null,json_encode(['objective'=>$objective]));

echo json_encode(['success'=>true,'id'=>$objectiveId,'sort_order'=>$sort]);
