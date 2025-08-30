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
$objective  = array_key_exists('objective', $_POST) ? trim($_POST['objective']) : null;
$ownerId    = array_key_exists('owner_id', $_POST) && $_POST['owner_id'] !== '' ? (int)$_POST['owner_id'] : null;
$progress   = array_key_exists('progress', $_POST) && $_POST['progress'] !== '' ? (int)$_POST['progress'] : null;

if (!$id || !$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

$stmt = $pdo->prepare('SELECT objective, owner_id, progress_percent FROM module_strategy_objectives WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id' => $id, ':sid' => $strategyId]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  echo json_encode(['success' => false, 'error' => 'Invalid objective']);
  exit;
}

$fields = [];
$params = [':id' => $id, ':uid' => $this_user_id];
$newData = [];

if ($objective !== null) {
  $fields[] = 'objective = :obj';
  $params[':obj'] = $objective;
  $newData['objective'] = $objective;
}

if ($ownerId !== null) {
  $chk = $pdo->prepare('SELECT id FROM person WHERE id = :id');
  $chk->execute([':id' => $ownerId]);
  if (!$chk->fetchColumn()) {
    echo json_encode(['success' => false, 'error' => 'Invalid owner']);
    exit;
  }
  $fields[] = 'owner_id = :owner';
  $params[':owner'] = $ownerId;
  $newData['owner_id'] = $ownerId;
}

if ($progress !== null) {
  if ($progress < 0 || $progress > 100) {
    echo json_encode(['success' => false, 'error' => 'Invalid progress']);
    exit;
  }
  $fields[] = 'progress_percent = :prog';
  $params[':prog'] = $progress;
  $newData['progress_percent'] = $progress;
}

if (!$fields) {
  echo json_encode(['success' => false, 'error' => 'Nothing to update']);
  exit;
}

$sql = 'UPDATE module_strategy_objectives SET ' . implode(',', $fields) . ', user_updated = :uid WHERE id = :id';
$pdo->prepare($sql)->execute($params);

$updated = array_merge($existing, $newData);
admin_audit_log($pdo, $this_user_id, 'module_strategy_objectives', $id, 'UPDATE', json_encode($existing), json_encode($updated));

echo json_encode(['success' => true]);
