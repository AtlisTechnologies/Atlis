<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../../includes/php_header.php';
require_permission('admin_finances_statements_of_work','read');
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
if ($id) {
  $stmt = $pdo->prepare('SELECT s.id, s.title, s.start_date, s.end_date, s.status_id, l.name AS status, s.file_name, s.file_path, s.file_size, s.file_type FROM admin_finances_statements_of_work s LEFT JOIN lookup_list_items l ON s.status_id = l.id WHERE s.id = :id');
  $stmt->execute([':id' => $id]);
  $data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $stmt = $pdo->query('SELECT s.id, s.title, s.start_date, s.end_date, s.status_id, l.name AS status, s.file_name, s.file_path, s.file_size, s.file_type FROM admin_finances_statements_of_work s LEFT JOIN lookup_list_items l ON s.status_id = l.id');
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode(['success' => true, 'data' => $data]);
