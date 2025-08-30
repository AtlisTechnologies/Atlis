<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('assets','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) { http_response_code(403); exit; }
$asset_id = (int)($_POST['asset_id'] ?? 0);

$assign = $pdo->prepare('SELECT id FROM module_asset_assignments WHERE asset_id=:id AND returned_date IS NULL');
$assign->execute([':id'=>$asset_id]);
$row = $assign->fetch(PDO::FETCH_ASSOC);
if (!$row) { http_response_code(400); echo 'No active assignment'; exit; }

$pdo->prepare('UPDATE module_asset_assignments SET returned_date=NOW(),user_updated=:uid WHERE id=:id')->execute([':uid'=>$this_user_id,':id'=>$row['id']]);
$pdo->prepare('UPDATE module_assets SET assignee_id=NULL,user_updated=:uid WHERE id=:id')->execute([':uid'=>$this_user_id,':id'=>$asset_id]);
$pdo->prepare('INSERT INTO module_asset_events (asset_id,event_type,memo,user_id,user_updated) VALUES (:aid,"return",NULL,:uid,:uid)')->execute([':aid'=>$asset_id,':uid'=>$this_user_id]);
admin_audit_log($pdo,$this_user_id,'module_asset_assignments',$row['id'],'asset.return',null,null,'Returned asset');

echo 'ok';
?>
