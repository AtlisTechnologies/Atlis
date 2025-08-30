<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_once __DIR__ . '/helpers.php';
require_permission('assets','create');

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
$is_encrypted = isset($_POST['is_encrypted']) ? 1 : 0;
$is_mdm_enrolled = isset($_POST['is_mdm_enrolled']) ? 1 : 0;
$last_patch_date = $_POST['last_patch_date'] ?: null;
$memo = $_POST['memo'] ?? null;
$compliance_flags = isset($_POST['compliance']) ? implode(',', (array)$_POST['compliance']) : null;
$tags = isset($_POST['tags']) ? array_filter(array_map('trim', (array)$_POST['tags'])) : [];
if($name==='') $name=null;
if($vendor==='') $vendor=null;
if($location==='') $location=null;

try {
  $asset_tag = generate_asset_tag($pdo);
  $stmt = $pdo->prepare('INSERT INTO module_assets (asset_tag,name,vendor,purchase_price,condition_id,location,is_encrypted,is_mdm_enrolled,last_patch_date,type_id,status_id,model,serial,purchase_date,warranty_expiration,compliance_flags,memo,user_id,user_updated) VALUES (:asset_tag,:name,:vendor,:purchase_price,:condition_id,:location,:is_encrypted,:is_mdm_enrolled,:last_patch_date,:type_id,:status_id,:model,:serial,:purchase_date,:warranty_expiration,:compliance_flags,:memo,:uid,:uid)');
  $stmt->execute([
    ':asset_tag'=>$asset_tag,
    ':name'=>$name,
    ':vendor'=>$vendor,
    ':purchase_price'=>$purchase_price,
    ':condition_id'=>$condition_id,
    ':location'=>$location,
    ':is_encrypted'=>$is_encrypted,
    ':is_mdm_enrolled'=>$is_mdm_enrolled,
    ':last_patch_date'=>$last_patch_date,
    ':type_id'=>$type_id,
    ':status_id'=>$status_id,
    ':model'=>$model,
    ':serial'=>$serial,
    ':purchase_date'=>$purchase_date,
    ':warranty_expiration'=>$warranty_expiration,
    ':compliance_flags'=>$compliance_flags,
    ':memo'=>$memo,
    ':uid'=>$this_user_id
  ]);
  $asset_id = (int)$pdo->lastInsertId();
  foreach ($tags as $tag) {
    $pdo->prepare('INSERT INTO module_asset_tags (asset_id, tag, user_id, user_updated) VALUES (:aid,:tag,:uid,:uid)')->execute([':aid'=>$asset_id,':tag'=>$tag,':uid'=>$this_user_id]);
  }
  require_once __DIR__ . '/../lib/qrlib.php';
  $qrDir = __DIR__ . '/../../../assets/uploads/' . $asset_id . '/qr/';
  if(!is_dir($qrDir)) mkdir($qrDir,0775,true);
  $qrPath = $qrDir . $asset_tag . '.png';
  QRcode::png(getURLDir()."admin/corporate/assets/view.php?id=".$asset_id,$qrPath,QR_ECLEVEL_L,4);
} catch (Exception $e) {
  $_SESSION['error_message'] = 'Unable to save asset';
  header('Location: ../asset.php');
  exit;
}

admin_audit_log($pdo,$this_user_id,'module_assets',$asset_id,'asset.create',null,json_encode([
  'asset_tag'=>$asset_tag,
  'type_id'=>$type_id,
  'status_id'=>$status_id,
  'model'=>$model,
  'serial'=>$serial,
  'name'=>$name,
  'vendor'=>$vendor,
  'purchase_price'=>$purchase_price,
  'condition_id'=>$condition_id,
  'location'=>$location,
  'is_encrypted'=>$is_encrypted,
  'is_mdm_enrolled'=>$is_mdm_enrolled,
  'last_patch_date'=>$last_patch_date
]),'Created asset');

$_SESSION['message'] = 'Asset saved';
header('Location: ../asset.php?id='.$asset_id);
exit;
?>
