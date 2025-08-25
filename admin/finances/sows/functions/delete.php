<?php
require '../../../../includes/php_header.php';
require_permission('sow','read');
require_permission('sow','delete');

$id = (int)($_POST['id'] ?? 0);
$token = $_POST['csrf_token'] ?? '';
if(!$id || $token !== ($_SESSION['csrf_token'] ?? '')){
  header('Location: ../index.php');
  exit;
}

$pdo->prepare('DELETE FROM module_sow_tasks WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_users WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_questions WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_links WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_notes WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_logins WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_line_items WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sow_files WHERE sow_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_sows WHERE id=:id')->execute([':id'=>$id]);

admin_audit_log($pdo,$this_user_id,'module_sows',$id,'DELETE');
header('Location: ../index.php?msg=deleted');
exit;
