<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'create');
header('Content-Type: application/json');

$strategyId = (int)($_POST['strategy_id'] ?? 0);
$personId = (int)($_POST['person_id'] ?? 0);
$roleId = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;

if(!$strategyId || !$personId){
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

// validate role against lookup list CORPORATE_STRATEGY_ROLE
if($roleId !== null){
  $checkRole = $pdo->prepare('SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = :name AND li.id = :id');
  $checkRole->execute([':name'=>'CORPORATE_STRATEGY_ROLE', ':id'=>$roleId]);
  if(!$checkRole->fetchColumn()){
    echo json_encode(['success'=>false,'error'=>'Invalid role']);
    exit;
  }
}

try {
  $stmt = $pdo->prepare('INSERT INTO module_strategy_collaborators (user_id,user_updated,strategy_id,person_id,role_id) VALUES (:uid,:uid,:sid,:pid,:rid)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':sid'=>$strategyId,
    ':pid'=>$personId,
    ':rid'=>$roleId
  ]);
  $id = (int)$pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_strategy_collaborators',$id,'CREATE',null,null,json_encode(['person_id'=>$personId]));
  echo json_encode(['success'=>true,'id'=>$id]);
} catch (PDOException $e){
  echo json_encode(['success'=>false,'error'=>'Database error']);
}
