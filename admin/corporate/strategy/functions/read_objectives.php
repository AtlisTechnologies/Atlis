<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');

$strategyId = (int)($_GET['strategy_id'] ?? 0);
if(!$strategyId){
  echo json_encode(['success'=>false,'error'=>'Missing strategy']);
  exit;
}

$stmt = $pdo->prepare('SELECT id,parent_id,objective AS title, progress_percent AS progress FROM module_strategy_objectives WHERE strategy_id = :sid ORDER BY parent_id, sort_order');
$stmt->execute([':sid'=>$strategyId]);
$objectives = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success'=>true,'objectives'=>$objectives]);
