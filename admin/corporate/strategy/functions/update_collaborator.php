<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'update');
header('Content-Type: application/json');

$id         = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);
$personId   = isset($_POST['person_id']) && $_POST['person_id'] !== '' ? (int)$_POST['person_id'] : null;
$roleId     = isset($_POST['role_id']) && $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;

if(!$id || !$strategyId){
  echo json_encode(['success'=>false,'error'=>'Missing data']);
  exit;
}

// fetch existing collaborator
$stmt = $pdo->prepare('SELECT person_id, role_id FROM module_strategy_collaborators WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id'=>$id, ':sid'=>$strategyId]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$existing){
  echo json_encode(['success'=>false,'error'=>'Invalid collaborator']);
  exit;
}

if($roleId !== null){
  $checkRole = $pdo->prepare('SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = :name AND li.id = :id');
  $checkRole->execute([':name'=>'CORPORATE_STRATEGY_ROLE',':id'=>$roleId]);
  if(!$checkRole->fetchColumn()){
    echo json_encode(['success'=>false,'error'=>'Invalid role']);
    exit;
  }
}

if($personId !== null){
  $chkPerson = $pdo->prepare('SELECT id FROM person WHERE id = :pid');
  $chkPerson->execute([':pid'=>$personId]);
  if(!$chkPerson->fetchColumn()){
    echo json_encode(['success'=>false,'error'=>'Invalid person']);
    exit;
  }
  // avoid duplicates
  $dup = $pdo->prepare('SELECT id FROM module_strategy_collaborators WHERE strategy_id = :sid AND person_id = :pid AND id != :id');
  $dup->execute([':sid'=>$strategyId, ':pid'=>$personId, ':id'=>$id]);
  if($dup->fetchColumn()){
    echo json_encode(['success'=>false,'error'=>'Person already collaborator']);
    exit;
  }
}

$fields = [];
$params = [':uid'=>$this_user_id, ':id'=>$id];
if($personId !== null){ $fields[] = 'person_id = :pid'; $params[':pid'] = $personId; }
if($roleId !== null){ $fields[] = 'role_id = :rid'; $params[':rid'] = $roleId; }

if(empty($fields)){
  echo json_encode(['success'=>false,'error'=>'Nothing to update']);
  exit;
}

$sql = 'UPDATE module_strategy_collaborators SET user_updated = :uid, ' . implode(',', $fields) . ' WHERE id = :id';
$pdo->prepare($sql)->execute($params);

$newData = [
  'person_id'=>$personId !== null ? $personId : $existing['person_id'],
  'role_id'=>$roleId !== null ? $roleId : $existing['role_id']
];
admin_audit_log($pdo,$this_user_id,'module_strategy_collaborators',$id,'UPDATE',json_encode($existing),json_encode($newData));

echo json_encode(['success'=>true]);
