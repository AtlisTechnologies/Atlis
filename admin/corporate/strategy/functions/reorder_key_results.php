<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'update');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

$strategyId  = (int)($_POST['strategy_id'] ?? 0);
$objectiveId = (int)($_POST['objective_id'] ?? 0);
$order       = json_decode($_POST['order'] ?? '[]', true);

if (!$strategyId || !$objectiveId || !is_array($order)) {
  echo json_encode(['success' => false, 'error' => 'Invalid data']);
  exit;
}

// ensure objective belongs to strategy
$chk = $pdo->prepare('SELECT id FROM module_strategy_objectives WHERE id = :id AND strategy_id = :sid');
$chk->execute([':id' => $objectiveId, ':sid' => $strategyId]);
if (!$chk->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Invalid objective']);
  exit;
}

if (empty($order)) {
  echo json_encode(['success' => true]);
  exit;
}

$placeholders = implode(',', array_fill(0, count($order), '?'));
$stmt = $pdo->prepare("SELECT id, sort_order FROM module_strategy_key_results WHERE objective_id = ? AND id IN ($placeholders)");
$stmt->execute(array_merge([$objectiveId], $order));
$existing = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // id => sort_order

$upd = $pdo->prepare('UPDATE module_strategy_key_results SET sort_order = :sort, user_updated = :uid WHERE id = :id');
foreach ($order as $index => $krId) {
  $krId = (int)$krId;
  if (!isset($existing[$krId])) {
    // verify key result belongs to objective
    $chk = $pdo->prepare('SELECT sort_order FROM module_strategy_key_results WHERE id = :id AND objective_id = :oid');
    $chk->execute([':id' => $krId, ':oid' => $objectiveId]);
    $row = $chk->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      echo json_encode(['success' => false, 'error' => 'Invalid key result']);
      exit;
    }
    $existing[$krId] = $row['sort_order'];
  }
  $upd->execute([':sort' => $index, ':uid' => $this_user_id, ':id' => $krId]);
  admin_audit_log($pdo, $this_user_id, 'module_strategy_key_results', $krId, 'REORDER', json_encode(['sort_order' => $existing[$krId]]), json_encode(['sort_order' => $index]));
}

echo json_encode(['success' => true]);
