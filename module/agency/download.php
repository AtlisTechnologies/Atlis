<?php
require '../../includes/php_header.php';

$type = $_GET['type'] ?? 'agency';
$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$types = [
  'organization' => ['table' => 'module_organization', 'perm' => 'organization', 'dir' => 'organization'],
  'agency'       => ['table' => 'module_agency',       'perm' => 'agency',       'dir' => 'agency'],
  'division'     => ['table' => 'module_division',     'perm' => 'division',     'dir' => 'division']
];

if (!isset($types[$type]) || !$id) {
  header('HTTP/1.1 400 Bad Request');
  exit('Bad Request');
}

require_permission($types[$type]['perm'], 'read');

$stmt = $pdo->prepare("SELECT file_name, file_path, file_size, file_type FROM {$types[$type]['table']} WHERE id = ?");
$stmt->execute([$id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$file || empty($file['file_path'])) {
  header('HTTP/1.1 404 Not Found');
  exit('File not found');
}

$uploadDir = dirname(__DIR__, 2) . "/module/agency/uploads/{$types[$type]['dir']}/";
$path = $uploadDir . $file['file_path'];

if (!is_file($path) || !is_readable($path)) {
  header('HTTP/1.1 404 Not Found');
  exit('File not found');
}

header('Content-Type: ' . $file['file_type']);
header('Content-Length: ' . $file['file_size']);
header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
readfile($path);
exit;
?>
