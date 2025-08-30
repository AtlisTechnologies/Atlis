<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('asset_policies','update');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){ http_response_code(405); exit; }
if(!verify_csrf_token($_POST['csrf_token'] ?? '')){ http_response_code(403); exit; }

$id = (int)($_POST['id'] ?? 0);
if($id){
    $pdo->prepare('UPDATE module_asset_policies SET active=0,user_updated=:uid WHERE id=:id')->execute([':uid'=>$this_user_id,':id'=>$id]);
    admin_audit_log($pdo,$this_user_id,'module_asset_policies',$id,'asset_policies.delete',null,'');
    $_SESSION['message'] = 'Policy deactivated';
}
header('Location: ../policy.php');
exit;
