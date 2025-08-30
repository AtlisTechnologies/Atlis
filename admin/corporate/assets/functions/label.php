<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('assets','read');
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT asset_tag FROM module_assets WHERE id=:id');
$stmt->execute([':id'=>$id]);
$asset = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$asset) { die('Not found'); }
$qrPath = __DIR__ . '/../../../assets/uploads/' . $id . '/qr/' . $asset['asset_tag'] . '.png';
if (!is_file($qrPath)) {
  require_once __DIR__ . '/../lib/qrlib.php';
  if(!is_dir(dirname($qrPath))) mkdir(dirname($qrPath),0775,true);
  QRcode::png(getURLDir()."admin/corporate/assets/view.php?id=".$id,$qrPath,QR_ECLEVEL_L,4);
}
$qr = base64_encode(file_get_contents($qrPath));
$asset_tag = $asset['asset_tag'];
?>
<!DOCTYPE html><html><head><link rel="stylesheet" href="../labels.css"></head><body>
<?php require __DIR__ . '/../label-template.php'; ?>
</body></html>
<?php
