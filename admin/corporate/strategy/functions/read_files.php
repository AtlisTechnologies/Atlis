<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_files', 'read');
header('Content-Type: application/json');

$strategyId = (int)($_GET['strategy_id'] ?? 0);
if (!$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing strategy']);
  exit;
}

$stmt = $pdo->prepare('SELECT id, file_name, file_path FROM module_strategy_files WHERE strategy_id = :sid ORDER BY date_created DESC');
$stmt->execute([':sid' => $strategyId]);
$files = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $row['file_path'] = getURLDir() . ltrim($row['file_path'], '/');
  $files[] = $row;
}

echo json_encode(['success' => true, 'files' => $files]);
