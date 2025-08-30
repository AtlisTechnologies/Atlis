<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'delete');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
  echo json_encode(['success' => false, 'error' => 'Invalid ID']);
  exit;
}

$stmt = $pdo->prepare('SELECT * FROM module_strategy WHERE id = :id');
$stmt->execute([':id' => $id]);
$existing = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$existing) {
  echo json_encode(['success' => false, 'error' => 'Strategy not found']);
  exit;
}

try {
  $pdo->beginTransaction();
  $pdo->prepare('DELETE kr FROM module_strategy_key_results kr JOIN module_strategy_objectives o ON kr.objective_id = o.id WHERE o.strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy_objectives WHERE strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy_tags WHERE strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy_collaborators WHERE strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy_notes WHERE strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy_files WHERE strategy_id = :id')->execute([':id' => $id]);
  $pdo->prepare('DELETE FROM module_strategy WHERE id = :id')->execute([':id' => $id]);
  $pdo->commit();
  admin_audit_log($pdo, $this_user_id, 'module_strategy', $id, 'DELETE', json_encode($existing), null, 'Deleted strategy');
  echo json_encode(['success' => true]);
} catch (PDOException $e) {
  $pdo->rollBack();
  echo json_encode(['success' => false, 'error' => 'Database error']);
}

