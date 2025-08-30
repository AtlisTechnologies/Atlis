<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_assets','read');
require_once __DIR__ . '/../lib/qrlib.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT asset_tag FROM module_assets WHERE id=:id');
$stmt->execute([':id'=>$id]);
$asset = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$asset) { die('Not found'); }
$data = getURLDir()."admin/corporate/assets/view.php?id=".$id;
ob_start();
QRcode::png($data,false,QR_ECLEVEL_L,4);
$qr = base64_encode(ob_get_clean());
?><!DOCTYPE html><html><head><link rel="stylesheet" href="../labels.css"></head><body>
<div class="label"><img src="data:image/png;base64,<?= $qr; ?>" alt="QR"><div class="text"><?= e($asset['asset_tag']); ?></div></div>
</body></html>
<?php
