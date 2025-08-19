<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$contact_type_id = (int)($_POST['contact_type_id'] ?? 0);
$contact_date = $_POST['contact_date'] ?? '';
$summary = trim($_POST['summary'] ?? '');
$contact_duration = $_POST['contact_duration'] !== '' ? (int)$_POST['contact_duration'] : null;
$contact_result = trim($_POST['contact_result'] ?? '');
$related_module = trim($_POST['related_module'] ?? '');
$related_id = $_POST['related_id'] !== '' ? (int)$_POST['related_id'] : null;

if($cid && $contact_type_id && $summary !== ''){
  $cdate = $contact_date !== '' ? date('Y-m-d H:i:s', strtotime($contact_date)) : null;
  $stmt = $pdo->prepare('INSERT INTO module_contractors_contacts (user_id,user_updated,contractor_id,contact_type_id,contact_date,summary,contact_duration,contact_result,related_module,related_id) VALUES (:uid,:uid,:cid,:type,:cdate,:summary,:duration,:result,:rmod,:rid)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$cid,
    ':type'=>$contact_type_id,
    ':cdate'=>$cdate,
    ':summary'=>$summary,
    ':duration'=>$contact_duration,
    ':result'=>$contact_result !== '' ? $contact_result : null,
    ':rmod'=>$related_module !== '' ? $related_module : null,
    ':rid'=>$related_id
  ]);
  $contactId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_contacts',$contactId,'CREATE','',json_encode(['contact_type_id'=>$contact_type_id,'summary'=>$summary]),'Added contact');
}
header('Location: ../contractor.php?id='.$cid.'#contacts');
exit;
