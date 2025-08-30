<?php
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('assets','read');
require_once __DIR__ . '/../lib/qrlib.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT asset_tag, model FROM module_assets WHERE id=:id');
$stmt->execute([':id'=>$id]);
$asset = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$asset) { die('Not found'); }

$qrTempDir = sys_get_temp_dir();
$data = getURLDir()."admin/assets/view.php?id=".$id;
header('Content-Type: image/png');
QRcode::png($data,false,QR_ECLEVEL_L,4);
?>
