<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

if(!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php');
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$statusId = $_POST['status_id'] ?? null;
$initial = $_POST['initial_contact_date'] ?? null;
$title = $_POST['title_role'] ?? null;
$acquaintance = $_POST['acquaintance'] ?? null;
$acqTypeId = $_POST['acquaintance_type_id'] ?? null;
$start = $_POST['start_date'] ?? null;
$end = $_POST['end_date'] ?? null;

if($id){
  $stmtOld = $pdo->prepare('SELECT status_id,initial_contact_date,title_role,acquaintance,acquaintance_type_id,start_date,end_date FROM module_contractors WHERE id=:id');
  $stmtOld->execute([':id'=>$id]);
  $old = $stmtOld->fetch(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare('UPDATE module_contractors SET status_id=:status,initial_contact_date=:initial,title_role=:title,acquaintance=:acquaintance,acquaintance_type_id=:acq_type,start_date=:start,end_date=:end,user_updated=:uid WHERE id=:id');
  $stmt->execute([
    ':status'=>$statusId,
    ':initial'=>$initial !== '' ? $initial : null,
    ':title'=>$title !== '' ? $title : null,
    ':acquaintance'=>$acquaintance !== '' ? $acquaintance : null,
    ':acq_type'=>$acqTypeId !== '' ? $acqTypeId : null,
    ':start'=>$start !== '' ? $start : null,
    ':end'=>$end !== '' ? $end : null,
    ':uid'=>$this_user_id,
    ':id'=>$id
  ]);

  $pidStmt = $pdo->prepare('SELECT person_id FROM module_contractors WHERE id=:id');
  $pidStmt->execute([':id'=>$id]);
  if($personId = $pidStmt->fetchColumn()){
    update_contractor_contact($pdo, (int)$personId);
  }

  admin_audit_log($pdo,$this_user_id,'module_contractors',$id,'UPDATE',json_encode($old),json_encode(['status_id'=>$statusId,'initial_contact_date'=>$initial,'title_role'=>$title,'acquaintance'=>$acquaintance,'acquaintance_type_id'=>$acqTypeId,'start_date'=>$start,'end_date'=>$end]),'Updated contractor');
}
header('Location: ../contractor.php?id='.$id);
exit;
