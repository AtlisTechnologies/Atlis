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

$stmt = $pdo->prepare('SELECT person_id, role_id FROM module_strategy_collaborators WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id' => $id, ':sid' => $strategyId]);
$collab = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$collab) {
  echo json_encode(['success' => false, 'error' => 'Invalid collaborator']);
  exit;
}

$pdo->prepare('DELETE FROM module_strategy_collaborators WHERE id = :id')->execute([':id' => $id]);
admin_audit_log($pdo, $this_user_id, 'module_strategy_collaborators', $id, 'DELETE', json_encode($collab), null);
echo json_encode(['success' => true]);
