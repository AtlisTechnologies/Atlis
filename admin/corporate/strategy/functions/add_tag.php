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

$strategyId = (int)($_POST['strategy_id'] ?? 0);
$tag        = trim($_POST['tag'] ?? '');

if (!$strategyId || $tag === '') {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

// ensure strategy exists
$chk = $pdo->prepare('SELECT id FROM module_strategy WHERE id = :id');
$chk->execute([':id' => $strategyId]);
if (!$chk->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Invalid strategy']);
  exit;
}

// prevent duplicate tags for same strategy
$dup = $pdo->prepare('SELECT id FROM module_strategy_tags WHERE strategy_id = :sid AND tag = :tag');
$dup->execute([':sid' => $strategyId, ':tag' => $tag]);
if ($dup->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Tag exists']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO module_strategy_tags (user_id,user_updated,strategy_id,tag) VALUES (:uid,:uid,:sid,:tag)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':sid' => $strategyId,
  ':tag' => $tag
]);
$tagId = (int)$pdo->lastInsertId();
admin_audit_log($pdo, $this_user_id, 'module_strategy_tags', $tagId, 'CREATE', null, json_encode(['tag' => $tag]));
echo json_encode(['success' => true, 'tag' => ['id' => $tagId, 'tag' => $tag]]);
