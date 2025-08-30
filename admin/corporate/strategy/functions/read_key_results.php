<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');

$strategyId = (int)($_GET['strategy_id'] ?? 0);
if (!$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing strategy']);
  exit;
}

$sql = 'SELECT kr.id, kr.name, kr.key_result AS title
        FROM module_strategy_key_results kr
        JOIN module_strategy_objectives o ON kr.objective_id = o.id
        WHERE o.strategy_id = :sid
        ORDER BY o.id, kr.sort_order';
$stmt = $pdo->prepare($sql);
$stmt->execute([':sid' => $strategyId]);
$keyResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'key_results' => $keyResults]);
