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
$personId   = (int)($_POST['person_id'] ?? 0);
$roleId     = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;

if (!$strategyId || !$personId) {
  echo json_encode(['success' => false, 'error' => 'Missing data']);
  exit;
}

// confirm strategy exists
$chk = $pdo->prepare('SELECT id FROM module_strategy WHERE id = :id');
$chk->execute([':id' => $strategyId]);
if (!$chk->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Invalid strategy']);
  exit;
}

// confirm person exists
$chk = $pdo->prepare('SELECT id FROM person WHERE id = :id');
$chk->execute([':id' => $personId]);
if (!$chk->fetchColumn()) {
  echo json_encode(['success' => false, 'error' => 'Invalid person']);
  exit;
}

// validate role against lookup list CORPORATE_STRATEGY_ROLE
if ($roleId !== null) {
  $checkRole = $pdo->prepare('SELECT li.id FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = :name AND li.id = :id');
  $checkRole->execute([':name' => 'CORPORATE_STRATEGY_ROLE', ':id' => $roleId]);
  if (!$checkRole->fetchColumn()) {
    echo json_encode(['success' => false, 'error' => 'Invalid role']);
    exit;
  }
}

try {
  $stmt = $pdo->prepare('INSERT INTO module_strategy_collaborators (user_id,user_updated,strategy_id,person_id,role_id) VALUES (:uid,:uid,:sid,:pid,:rid)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':sid' => $strategyId,
    ':pid' => $personId,
    ':rid' => $roleId
  ]);
  $id = (int)$pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_strategy_collaborators', $id, 'CREATE', null, json_encode(['person_id' => $personId, 'role_id' => $roleId]));
  echo json_encode(['success' => true, 'id' => $id]);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'error' => 'Database error']);
}
