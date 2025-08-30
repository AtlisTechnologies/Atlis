<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_notes', 'read');
header('Content-Type: application/json');

$strategyId = (int)($_GET['strategy_id'] ?? 0);
if (!$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing strategy']);
  exit;
}

$stmt = $pdo->prepare('SELECT id, note FROM module_strategy_notes WHERE strategy_id = :sid ORDER BY date_created DESC');
$stmt->execute([':sid' => $strategyId]);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'notes' => $notes]);
