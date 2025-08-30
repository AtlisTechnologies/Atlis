<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'create');
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
$title       = trim($_POST['title'] ?? '');

if (!$strategyId || !$objectiveId || $title === '') {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

// ensure objective belongs to strategy
$chk = $pdo->prepare('SELECT id FROM module_strategy_objectives WHERE id = :oid AND strategy_id = :sid');
$chk->execute([':oid' => $objectiveId, ':sid' => $strategyId]);
if (!$chk->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Invalid objective']);
  exit;
}

// determine sort order within objective
$sortStmt = $pdo->prepare('SELECT COALESCE(MAX(sort_order),0)+1 FROM module_strategy_key_results WHERE objective_id = :oid');
$sortStmt->execute([':oid' => $objectiveId]);
$sort = (int)$sortStmt->fetchColumn();

$stmt = $pdo->prepare('INSERT INTO module_strategy_key_results (user_id,user_updated,objective_id,name,key_result,sort_order) VALUES (:uid,:uid,:oid,:name,:kr,:sort)');
$stmt->execute([
  ':uid'  => $this_user_id,
  ':oid'  => $objectiveId,
  ':name' => $title,
  ':kr'   => $title,
  ':sort' => $sort
]);
$krId = (int)$pdo->lastInsertId();
admin_audit_log($pdo, $this_user_id, 'module_strategy_key_results', $krId, 'CREATE', null, json_encode(['name' => $title]));

echo json_encode(['success' => true, 'id' => $krId, 'sort_order' => $sort]);
