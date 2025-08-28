<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');
echo json_encode(['success' => true, 'html' => '']);
