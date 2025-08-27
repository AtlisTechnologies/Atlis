<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_prospecting', 'update');
header('Content-Type: application/json');
echo json_encode(['success' => false, 'error' => 'Not implemented']);
