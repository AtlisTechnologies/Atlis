<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'delete');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

$id         = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);
if (!$id || !$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

$stmt = $pdo->prepare('SELECT kr.name, kr.key_result FROM module_strategy_key_results kr JOIN module_strategy_objectives o ON kr.objective_id = o.id WHERE kr.id = :id AND o.strategy_id = :sid');
$stmt->execute([':id' => $id, ':sid' => $strategyId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
  echo json_encode(['success' => false, 'error' => 'Invalid key result']);
  exit;
}

$pdo->prepare('DELETE FROM module_strategy_key_results WHERE id = :id')->execute([':id' => $id]);
admin_audit_log($pdo, $this_user_id, 'module_strategy_key_results', $id, 'DELETE', json_encode($row), null);

echo json_encode(['success' => true]);
