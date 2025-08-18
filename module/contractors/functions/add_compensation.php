<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$amount = trim($_POST['amount'] ?? '');
$type = trim($_POST['type'] ?? '');
$start = $_POST['start_date'] ?? null;
$end   = $_POST['end_date'] ?? null;
if($cid && $amount !== '' && $type !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_contractors_compensation (user_id,user_updated,contractor_id,amount,type,start_date,end_date) VALUES (:uid,:uid,:cid,:amount,:type,:start,:end)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$cid,
    ':amount'=>$amount,
    ':type'=>$type,
    ':start'=>$start !== '' ? $start : null,
    ':end'=>$end !== '' ? $end : null
  ]);
  $compId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_compensation',$compId,'CREATE','',json_encode(['amount'=>$amount,'type'=>$type]),'Added compensation');
}
header('Location: ../../../admin/contractors/contractor.php?id='.$cid.'#compensation');
exit;
