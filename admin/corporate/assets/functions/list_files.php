<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('assets','read');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) { http_response_code(403); exit; }
$asset_id = (int)($_POST['asset_id'] ?? 0);
$stmt = $pdo->prepare('SELECT id,file_path FROM module_asset_files WHERE asset_id=:id');
$stmt->execute([':id'=>$asset_id]);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
