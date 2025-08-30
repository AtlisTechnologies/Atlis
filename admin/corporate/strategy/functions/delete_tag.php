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

$tagId      = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);

if (!$tagId || !$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

$stmt = $pdo->prepare('SELECT tag FROM module_strategy_tags WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id' => $tagId, ':sid' => $strategyId]);
$tag = $stmt->fetchColumn();
if (!$tag) {
  echo json_encode(['success' => false, 'error' => 'Invalid tag']);
  exit;
}

$pdo->prepare('DELETE FROM module_strategy_tags WHERE id = :id')->execute([':id' => $tagId]);
admin_audit_log($pdo, $this_user_id, 'module_strategy_tags', $tagId, 'DELETE', json_encode(['tag' => $tag]), null);
echo json_encode(['success' => true]);
