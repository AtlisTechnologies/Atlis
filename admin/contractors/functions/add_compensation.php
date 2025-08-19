<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$comp_type_id = (int)($_POST['compensation_type_id'] ?? 0);
$payment_method_id = (int)($_POST['payment_method_id'] ?? 0);
$amount = trim($_POST['amount'] ?? '');
$start = $_POST['effective_start'] ?? '';
$end   = $_POST['effective_end'] ?? '';
$notes = trim($_POST['notes'] ?? '');
if($cid && $comp_type_id && $payment_method_id && $amount !== '' && $start !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_contractors_compensation (user_id,user_updated,contractor_id,compensation_type_id,payment_method_id,amount,effective_start,effective_end,notes) VALUES (:uid,:uid,:cid,:ctype,:pmethod,:amount,:start,:end,:notes)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$cid,
    ':ctype'=>$comp_type_id,
    ':pmethod'=>$payment_method_id,
    ':amount'=>$amount,
    ':start'=>$start,
    ':end'=>$end !== '' ? $end : null,
    ':notes'=>$notes !== '' ? $notes : null
  ]);
  $compId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_compensation',$compId,'CREATE','',json_encode(['amount'=>$amount,'type'=>$comp_type_id]),'Added compensation');
}
header('Location: ../contractor.php?id='.$cid.'#compensation');
exit;
