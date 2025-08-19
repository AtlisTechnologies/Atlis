<?php
require __DIR__ . '/../../includes/php_header.php';
require_permission('contractors','update');

$id = (int)($_POST['id'] ?? 0);
$statusId = $_POST['status_id'] ?? null;
$payTypeId = $_POST['pay_type_id'] ?? null;
$start = $_POST['start_date'] ?? null;
$end = $_POST['end_date'] ?? null;
$rate = $_POST['current_rate'] ?? null;

if($id){
  $stmtOld = $pdo->prepare('SELECT status_id,pay_type_id,start_date,end_date,current_rate FROM module_contractors WHERE id=:id');
  $stmtOld->execute([':id'=>$id]);
  $old = $stmtOld->fetch(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare('UPDATE module_contractors SET status_id=:status,pay_type_id=:pay,start_date=:start,end_date=:end,current_rate=:rate,user_updated=:uid WHERE id=:id');
  $stmt->execute([
    ':status'=>$statusId,
    ':pay'=>$payTypeId,
    ':start'=>$start !== '' ? $start : null,
    ':end'=>$end !== '' ? $end : null,
    ':rate'=>$rate !== '' ? $rate : null,
    ':uid'=>$this_user_id,
    ':id'=>$id
  ]);

  admin_audit_log($pdo,$this_user_id,'module_contractors',$id,'UPDATE',json_encode($old),json_encode(['status_id'=>$statusId,'pay_type_id'=>$payTypeId,'start_date'=>$start,'end_date'=>$end,'current_rate'=>$rate]),'Updated contractor');
}
header('Location: ../contractor.php?id='.$id);
exit;

