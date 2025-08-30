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

$stmt = $pdo->prepare('SELECT objective FROM module_strategy_objectives WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id' => $id, ':sid' => $strategyId]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  echo json_encode(['success' => false, 'error' => 'Invalid objective']);
  exit;
}

$ids = [];
$stack = [$id];
while ($stack) {
  $current = array_pop($stack);
  $ids[] = $current;
  $childStmt = $pdo->prepare('SELECT id FROM module_strategy_objectives WHERE parent_id = :pid');
  $childStmt->execute([':pid' => $current]);
  $children = $childStmt->fetchAll(PDO::FETCH_COLUMN);
  foreach ($children as $c) {
    $stack[] = (int)$c;
  }
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
try {
  $pdo->beginTransaction();
  $pdo->prepare("DELETE FROM module_strategy_key_results WHERE objective_id IN ($placeholders)")->execute($ids);
  $pdo->prepare("DELETE FROM module_strategy_objectives WHERE id IN ($placeholders)")->execute($ids);
  $pdo->commit();
} catch (PDOException $e) {
  $pdo->rollBack();
  echo json_encode(['success' => false, 'error' => 'Database error']);
  exit;
}

admin_audit_log($pdo, $this_user_id, 'module_strategy_objectives', $id, 'DELETE', json_encode($existing), null);
echo json_encode(['success' => true]);
