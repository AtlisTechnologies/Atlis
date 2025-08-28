<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');

$status = trim($_GET['status'] ?? '');
$priority = trim($_GET['priority'] ?? '');
$tags = trim($_GET['tags'] ?? '');

$sql = 'SELECT s.id, s.title, s.status_id, s.priority_id, GROUP_CONCAT(t.tag) AS tags
        FROM module_strategy s
        LEFT JOIN module_strategy_tags t ON t.strategy_id = s.id
        WHERE 1=1';
$params = [];
if ($status !== '') {
  $sql .= ' AND s.status_id = :status';
  $params[':status'] = $status;
}
if ($priority !== '') {
  $sql .= ' AND s.priority_id = :priority';
  $params[':priority'] = $priority;
}
$sql .= ' GROUP BY s.id';
if ($tags !== '') {
  $sql .= ' HAVING tags LIKE :tags';
  $params[':tags'] = "%$tags%";
}
$sql .= ' ORDER BY s.date_created DESC';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$strategies = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['success' => true, 'strategies' => $strategies]);
