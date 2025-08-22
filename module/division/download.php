<?php
require '../../includes/php_header.php';
require_permission('division','read');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) {
  header('HTTP/1.1 400 Bad Request');
  exit('Bad Request');
}

$stmt = $pdo->prepare('SELECT file_name, file_path, file_size, file_type FROM module_division WHERE id = ?');
$stmt->execute([$id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$file || empty($file['file_path'])) {
  header('HTTP/1.1 404 Not Found');
  exit('File not found');
}

$uploadDir = dirname(__DIR__, 3) . '/uploads/division/';
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

