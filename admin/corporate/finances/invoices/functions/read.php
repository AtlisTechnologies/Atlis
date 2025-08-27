<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_invoices','read');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare('SELECT * FROM admin_finances_invoices WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $stmt = $pdo->query('SELECT * FROM admin_finances_invoices');
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode(['success' => true, 'data' => $data]);
