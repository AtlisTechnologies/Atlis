<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy_notes', 'create');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

// Validate input
$strategyId = (int)($_POST['strategy_id'] ?? 0);
$note       = trim($_POST['note'] ?? '');

if (!$strategyId || $note === '') {
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

try {
  $stmt = $pdo->prepare('INSERT INTO module_strategy_notes (user_id,user_updated,strategy_id,note) VALUES (:uid,:uid,:sid,:note)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':sid' => $strategyId,
    ':note' => $note
  ]);
  $noteId = (int)$pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_strategy_notes', $noteId, 'CREATE', null, json_encode(['note' => $note]));
  echo json_encode(['success' => true, 'note' => ['id' => $noteId, 'note' => $note]]);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'error' => 'Database error']);
}
