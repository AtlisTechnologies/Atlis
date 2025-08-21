<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$contractor_id = (int)($_POST['contractor_id'] ?? 0);
$contact_id    = (int)($_POST['contact_id'] ?? 0);
$id            = (int)($_POST['id'] ?? 0);
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
if($contractor_id && $contact_id && $id && $response_type_id && $response_text !== ''){
  $deadline_dt  = $deadline !== '' ? date('Y-m-d H:i:s', strtotime($deadline)) : null;
  $completed_dt = $completed_date !== '' ? date('Y-m-d H:i:s', strtotime($completed_date)) : null;
  $stmt = $pdo->prepare('UPDATE module_contractors_contact_responses SET user_updated=:uid, response_type_id=:type, is_urgent=:urgent, deadline=:deadline, response_text=:text, assigned_user_id=:assigned, completed_date=:completed WHERE id=:id AND contact_id=:cid');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':type'=>$response_type_id,
    ':urgent'=>$is_urgent,
    ':deadline'=>$deadline_dt,
    ':text'=>$response_text,
    ':assigned'=>$assigned_user_id,
    ':completed'=>$completed_dt,
    ':id'=>$id,
    ':cid'=>$contact_id
  ]);
  admin_audit_log($pdo,$this_user_id,'module_contractors_contact_responses',$id,'UPDATE','',json_encode(['response_type_id'=>$response_type_id,'response_text'=>$response_text]),'Updated contact response');
  $ok = true;
}

$loc = '../contractor.php?id='.$contractor_id;
$loc .= $ok ? '&msg=response-saved#contacts' : '#contacts';
header('Location: '.$loc);
exit;
