<?php
require '../../../includes/php_header.php';
require_permission('contractors','update');

$cid  = (int)($_POST['contractor_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$phone= trim($_POST['phone'] ?? '');
$email= trim($_POST['email'] ?? '');
$related_module = trim($_POST['related_module'] ?? '');
$related_id = $_POST['related_id'] !== '' ? (int)$_POST['related_id'] : null;
if($cid && $name !== ''){
  $stmt = $pdo->prepare('INSERT INTO module_contractors_contacts (user_id,user_updated,contractor_id,name,phone,email,related_module,related_id) VALUES (:uid,:uid,:cid,:name,:phone,:email,:rmod,:rid)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':cid'=>$cid,
    ':name'=>$name,
    ':phone'=>$phone,
    ':email'=>$email,
    ':rmod'=>$related_module !== '' ? $related_module : null,
    ':rid'=>$related_id
  ]);
  $contactId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_contractors_contacts',$contactId,'CREATE','',json_encode(['name'=>$name]),'Added contact');
}
header('Location: ../../../admin/contractors/contractor.php?id='.$cid.'#contacts');
exit;
