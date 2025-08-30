<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_notes', 'delete');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

$noteId     = (int)($_POST['id'] ?? 0);
$strategyId = (int)($_POST['strategy_id'] ?? 0);

if (!$noteId || !$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

// verify note belongs to strategy
$stmt = $pdo->prepare('SELECT note FROM module_strategy_notes WHERE id = :id AND strategy_id = :sid');
$stmt->execute([':id' => $noteId, ':sid' => $strategyId]);
$note = $stmt->fetchColumn();
if (!$note) {
  echo json_encode(['success' => false, 'error' => 'Invalid note']);
  exit;
}

$pdo->prepare('DELETE FROM module_strategy_notes WHERE id = :id')->execute([':id' => $noteId]);
admin_audit_log($pdo, $this_user_id, 'module_strategy_notes', $noteId, 'DELETE', $note, '');
echo json_encode(['success' => true]);
