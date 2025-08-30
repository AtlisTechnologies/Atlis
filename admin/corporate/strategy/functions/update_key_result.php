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

$id         = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);
$title      = isset($_POST['title']) ? trim($_POST['title']) : null;
$objectiveId = isset($_POST['objective_id']) && $_POST['objective_id'] !== '' ? (int)$_POST['objective_id'] : null;

if (!$id || !$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

$stmt = $pdo->prepare('SELECT kr.name, kr.key_result, kr.objective_id FROM module_strategy_key_results kr JOIN module_strategy_objectives o ON kr.objective_id = o.id WHERE kr.id = :id AND o.strategy_id = :sid');
$stmt->execute([':id' => $id, ':sid' => $strategyId]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  echo json_encode(['success' => false, 'error' => 'Invalid key result']);
  exit;
}

$fields = [];
$params = [':id' => $id, ':uid' => $this_user_id];
$newData = [];

if ($title !== null) {
  $fields[] = 'name = :name';
  $fields[] = 'key_result = :kr';
  $params[':name'] = $title;
  $params[':kr'] = $title;
  $newData['name'] = $title;
}

if ($objectiveId !== null && $objectiveId !== (int)$existing['objective_id']) {
  // ensure new objective belongs to strategy
  $chk = $pdo->prepare('SELECT id FROM module_strategy_objectives WHERE id = :oid AND strategy_id = :sid');
  $chk->execute([':oid' => $objectiveId, ':sid' => $strategyId]);
  if (!$chk->fetchColumn()) {
    echo json_encode(['success' => false, 'error' => 'Invalid objective']);
    exit;
  }
  $fields[] = 'objective_id = :oid';
  $params[':oid'] = $objectiveId;
  $newData['objective_id'] = $objectiveId;
}

if (!$fields) {
  echo json_encode(['success' => false, 'error' => 'Nothing to update']);
  exit;
}

$sql = 'UPDATE module_strategy_key_results SET ' . implode(',', $fields) . ', user_updated = :uid WHERE id = :id';
$pdo->prepare($sql)->execute($params);

$updated = array_merge($existing, $newData);
admin_audit_log($pdo, $this_user_id, 'module_strategy_key_results', $id, 'UPDATE', json_encode($existing), json_encode($updated));

echo json_encode(['success' => true]);
