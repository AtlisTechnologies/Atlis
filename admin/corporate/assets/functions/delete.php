<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('admin_assets','delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['error_message'] = 'Method not allowed';
  header('Location: ../index.php');
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  $_SESSION['error_message'] = 'Invalid CSRF token';
  header('Location: ../index.php');
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM module_assets WHERE id=:id');
$stmt->execute([':id'=>$id]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  $_SESSION['error_message'] = 'Asset not found';
  header('Location: ../index.php');
  exit;
}

$pdo->prepare('DELETE FROM module_assets WHERE id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_asset_tags WHERE asset_id=:id')->execute([':id'=>$id]);
$pdo->prepare('DELETE FROM module_asset_files WHERE asset_id=:id')->execute([':id'=>$id]);

admin_audit_log($pdo,$this_user_id,'module_assets',$id,'asset.delete',json_encode($existing),null,'Deleted asset');

$_SESSION['message'] = 'Asset deleted';
header('Location: ../index.php');
exit;
?>
