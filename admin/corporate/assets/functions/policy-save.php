<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('asset_policies','update');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){ http_response_code(405); exit; }
if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ http_response_code(403); exit; }

$id = (int)($_POST['id'] ?? 0);
$version = trim($_POST['version'] ?? '');
$effective_date = $_POST['effective_date'] ?? '';
$content = $_POST['content'] ?? '';

if($version === '' || $effective_date === '' || $content === ''){
    $_SESSION['error_message'] = 'All fields are required';
    header('Location: ../policy.php' . ($id ? '?id='.$id : ''));
    exit;
}

if($id){
    $stmt = $pdo->prepare('UPDATE module_asset_policies SET version=:version,effective_date=:eff,content=:content,user_updated=:uid WHERE id=:id');
    $stmt->execute([':version'=>$version,':eff'=>$effective_date,':content'=>$content,':uid'=>$this_user_id,':id'=>$id]);
    admin_audit_log($pdo,$this_user_id,'module_asset_policies',$id,'asset_policies.update',null,json_encode(['version'=>$version,'effective_date'=>$effective_date]));
    $_SESSION['message'] = 'Policy updated';
} else {
    $stmt = $pdo->prepare('INSERT INTO module_asset_policies (version,effective_date,content,user_id,user_updated) VALUES (:version,:eff,:content,:uid,:uid)');
    $stmt->execute([':version'=>$version,':eff'=>$effective_date,':content'=>$content,':uid'=>$this_user_id]);
    $id = (int)$pdo->lastInsertId();
    admin_audit_log($pdo,$this_user_id,'module_asset_policies',$id,'asset_policies.create',null,json_encode(['version'=>$version,'effective_date'=>$effective_date]));
    $_SESSION['message'] = 'Policy created';
}
header('Location: ../policy.php');
exit;
