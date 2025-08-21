<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$id   = (int)($_POST['id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$cid.'#contacts');
  exit;
}

$contact_type_id = (int)($_POST['contact_type_id'] ?? 0);
$contact_date = $_POST['contact_date'] ?? '';
$summary = trim($_POST['summary'] ?? '');
$contact_duration = $_POST['contact_duration'] !== '' ? (int)$_POST['contact_duration'] : null;
$contact_result = trim($_POST['contact_result'] ?? '');
$related_module = trim($_POST['related_module'] ?? '');
$related_id = $_POST['related_id'] !== '' ? (int)$_POST['related_id'] : null;

if($cid && $id && $contact_type_id && $summary !== ''){
  $cdate = $contact_date !== '' ? date('Y-m-d H:i:s', strtotime($contact_date)) : null;
  $stmt = $pdo->prepare('UPDATE module_contractors_contacts SET user_updated=:uid, contact_type_id=:type, contact_date=:cdate, summary=:summary, contact_duration=:duration, contact_result=:result, related_module=:rmod, related_id=:rid WHERE id=:id AND contractor_id=:cid');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':type'=>$contact_type_id,
    ':cdate'=>$cdate,
    ':summary'=>$summary,
    ':duration'=>$contact_duration,
    ':result'=>$contact_result !== '' ? $contact_result : null,
    ':rmod'=>$related_module !== '' ? $related_module : null,
    ':rid'=>$related_id,
    ':id'=>$id,
    ':cid'=>$cid
  ]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_contacts',$id,'UPDATE','',json_encode(['contact_type_id'=>$contact_type_id,'summary'=>$summary]),'Updated contact');
  $msg = 'contact-updated';
} else {
  $msg = null;
}

$loc = '../contractor.php?id='.$cid;
$loc .= $msg ? '&msg='.$msg.'#contacts' : '#contacts';
header('Location: '.$loc);
exit;
