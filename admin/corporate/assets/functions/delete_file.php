<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('admin_assets','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) { http_response_code(403); exit; }
$id = (int)($_POST['id'] ?? 0);
$stmt = $pdo->prepare('SELECT asset_id,file_path FROM module_asset_files WHERE id=:id');
$stmt->execute([':id'=>$id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$file) { http_response_code(404); exit; }
$path = __DIR__.'/../uploads/'.$file['asset_id'].'/'.$file['file_path'];
if (is_file($path)) unlink($path);
$pdo->prepare('DELETE FROM module_asset_files WHERE id=:id')->execute([':id'=>$id]);
admin_audit_log($pdo,$this_user_id,'module_asset_files',$id,'asset.delete',json_encode($file),null,'Deleted file');
echo 'ok';
?>
