<?php
require '../../../includes/php_header.php';
require_permission('contractors','create');

if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php');
  exit;
}

$userId = (int)($_POST['user_id'] ?? 0);
if($userId){
  $stmt = $pdo->prepare('SELECT p.id FROM users u JOIN person p ON u.id = p.user_id WHERE u.id = :uid');
  $stmt->execute([':uid'=>$userId]);
  $personId = $stmt->fetchColumn();
  if($personId){
    $statusItems = get_lookup_items($pdo, 'CONTRACTOR_STATUS');
    $statusId = null;
    foreach($statusItems as $s){ if(!empty($s['is_default'])){ $statusId = $s['id']; break; } }
    if(!$statusId && !empty($statusItems)){ $statusId = $statusItems[0]['id']; }

    $typeItems = get_lookup_items($pdo, 'CONTRACTOR_TYPE');
    $typeId = null;
    foreach($typeItems as $t){ if(!empty($t['is_default'])){ $typeId = $t['id']; break; } }
    if(!$typeId && !empty($typeItems)){ $typeId = $typeItems[0]['id']; }

    $stmt = $pdo->prepare('INSERT INTO module_contractors (user_id,user_updated,person_id,status_id,contractor_type_id) VALUES (:user_id,:uid,:person_id,:status_id,:type_id)');
    $stmt->execute([
      ':user_id'=>$userId,
      ':uid'=>$this_user_id,
      ':person_id'=>$personId,
      ':status_id'=>$statusId,
      ':type_id'=>$typeId
    ]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_contractors',$id,'CREATE',null,json_encode(['user_id'=>$userId,'person_id'=>$personId]),'Created contractor');
    header('Location: ../contractor.php?id='.$id);
    exit;
  }
}
header('Location: ../contractor.php');
exit;
