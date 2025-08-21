<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$contractor_id = (int)($_POST['contractor_id'] ?? 0);
$contact_id    = (int)($_POST['contact_id'] ?? 0);
$token         = $_POST['csrf_token'] ?? '';

if($token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../contractor.php?id='.$contractor_id.'#contacts');
  exit;
}

$response_type_id = (int)($_POST['response_type_id'] ?? 0);
$response_text    = trim($_POST['response_text'] ?? '');
$is_urgent        = isset($_POST['is_urgent']) ? 1 : 0;
$deadline         = $_POST['deadline'] ?? '';
$assigned_user_id = $_POST['assigned_user_id'] !== '' ? (int)$_POST['assigned_user_id'] : null;
$completed_date   = $_POST['completed_date'] ?? '';

$ok = false;
if($contractor_id && $contact_id && $response_type_id && $response_text !== ''){
  $deadline_dt  = $deadline !== '' ? date('Y-m-d H:i:s', strtotime($deadline)) : null;
  $completed_dt = $completed_date !== '' ? date('Y-m-d H:i:s', strtotime($completed_date)) : null;
  $stmt = $pdo->prepare('INSERT INTO module_contractors_contact_responses (user_id,user_updated,contact_id,response_type_id,is_urgent,deadline,response_text,assigned_user_id,completed_date) VALUES (:uid,:uid,:cid,:type,:urgent,:deadline,:text,:assigned,:completed)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$contact_id,
    ':type'=>$response_type_id,
    ':urgent'=>$is_urgent,
    ':deadline'=>$deadline_dt,
    ':text'=>$response_text,
    ':assigned'=>$assigned_user_id,
    ':completed'=>$completed_dt
  ]);
  $rid = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_contact_responses',$rid,'CREATE','',json_encode(['response_type_id'=>$response_type_id,'response_text'=>$response_text]),'Added contact response');
  $ok = true;
}

$loc = '../contractor.php?id='.$contractor_id;
$loc .= $ok ? '&msg=response-saved#contacts' : '#contacts';
header('Location: '.$loc);
exit;
