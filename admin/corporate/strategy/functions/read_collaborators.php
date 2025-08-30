<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');

$strategyId = (int)($_GET['strategy_id'] ?? 0);
if (!$strategyId) {
  echo json_encode(['success' => false, 'error' => 'Missing strategy']);
  exit;
}

$stmt = $pdo->prepare('SELECT c.id, CONCAT(p.first_name, " ", p.last_name) AS name, li.label AS role
                        FROM module_strategy_collaborators c
                        LEFT JOIN person p ON c.person_id = p.id
                        LEFT JOIN lookup_list_items li ON c.role_id = li.id
                        WHERE c.strategy_id = :sid');
$stmt->execute([':sid' => $strategyId]);
$collaborators = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'collaborators' => $collaborators]);
