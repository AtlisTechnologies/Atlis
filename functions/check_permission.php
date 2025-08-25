<?php
if (!isset($pdo)) {
  require '../includes/php_header.php';
}
header('Content-Type: application/json');
$module = $_GET['module'] ?? '';
$action = $_GET['action'] ?? 'read';
require_permission($module, $action);
echo json_encode(['authorized' => true]);

