<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_once __DIR__ . '/helpers.php';
require_permission('admin_assets','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['error_message'] = 'Method not allowed';
  header('Location: ../asset.php');
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  $_SESSION['error_message'] = 'Invalid CSRF token';
  header('Location: ../asset.php');
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$type_id = (int)($_POST['type_id'] ?? 0);
$status_id = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$name = trim($_POST['name'] ?? '');
$vendor = trim($_POST['vendor'] ?? '');
$model = trim($_POST['model'] ?? '');
$serial = trim($_POST['serial'] ?? '');
$purchase_date = $_POST['purchase_date'] ?: null;
$warranty_expiration = $_POST['warranty_expiration'] ?: null;
$purchase_price = $_POST['purchase_price'] !== '' ? (float)$_POST['purchase_price'] : null;
$condition_id = $_POST['condition_id'] !== '' ? (int)$_POST['condition_id'] : null;
$location = trim($_POST['location'] ?? '');
$memo = $_POST['memo'] ?? null;
$compliance_flags = isset($_POST['compliance']) ? implode(',', (array)$_POST['compliance']) : null;
$tags = isset($_POST['tags']) ? array_filter(array_map('trim', (array)$_POST['tags'])) : [];
if($name==='') $name=null;
if($vendor==='') $vendor=null;
if($location==='') $location=null;

$stmt = $pdo->prepare('SELECT * FROM module_assets WHERE id=:id');
$stmt->execute([':id'=>$id]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  $_SESSION['error_message'] = 'Asset not found';
  header('Location: ../index.php');
  exit;
}

try {
  $pdo->prepare('UPDATE module_assets SET type_id=:type_id,status_id=:status_id,name=:name,vendor=:vendor,model=:model,serial=:serial,purchase_date=:purchase_date,warranty_expiration=:warranty_expiration,purchase_price=:purchase_price,condition_id=:condition_id,location=:location,compliance_flags=:compliance_flags,memo=:memo,user_updated=:uid WHERE id=:id')
      ->execute([
        ':type_id'=>$type_id,
        ':status_id'=>$status_id,
        ':name'=>$name,
        ':vendor'=>$vendor,
        ':model'=>$model,
        ':serial'=>$serial,
        ':purchase_date'=>$purchase_date,
        ':warranty_expiration'=>$warranty_expiration,
        ':purchase_price'=>$purchase_price,
        ':condition_id'=>$condition_id,
        ':location'=>$location,
        ':compliance_flags'=>$compliance_flags,
        ':memo'=>$memo,
        ':uid'=>$this_user_id,
        ':id'=>$id
      ]);
  $pdo->prepare('DELETE FROM module_asset_tags WHERE asset_id=:id')->execute([':id'=>$id]);
  foreach ($tags as $tag) {
    $pdo->prepare('INSERT INTO module_asset_tags (asset_id,tag,user_id,user_updated) VALUES (:aid,:tag,:uid,:uid)')->execute([':aid'=>$id,':tag'=>$tag,':uid'=>$this_user_id]);
  }
} catch (Exception $e) {
  $_SESSION['error_message'] = 'Unable to update asset';
  header('Location: ../asset.php?id='.$id);
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_assets',$id,'asset.update',json_encode($existing),json_encode([
  'type_id'=>$type_id,
  'status_id'=>$status_id,
  'name'=>$name,
  'vendor'=>$vendor,
  'model'=>$model,
  'serial'=>$serial,
  'purchase_price'=>$purchase_price,
  'condition_id'=>$condition_id,
  'location'=>$location
]),'Updated asset');

$_SESSION['message'] = 'Asset updated';
header('Location: ../asset.php?id='.$id);
exit;
?>
