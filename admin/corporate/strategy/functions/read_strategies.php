<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'read');
header('Content-Type: application/json');

$status = trim($_GET['status'] ?? '');
$priority = trim($_GET['priority'] ?? '');
$category = trim($_GET['category'] ?? '');
$tags = trim($_GET['tags'] ?? '');

$sql = 'SELECT s.id, s.title,
               s.status_id, ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color,
               s.priority_id, lp.label AS priority_label, COALESCE(lpattr.attr_value, "secondary") AS priority_color,
               s.category_id, lc.label AS category_label,
               GROUP_CONCAT(t.tag) AS tags
        FROM module_strategy s
        LEFT JOIN module_strategy_tags t ON t.strategy_id = s.id
        LEFT JOIN lookup_list_items ls ON s.status_id = ls.id
        LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS"
        LEFT JOIN lookup_list_items lp ON s.priority_id = lp.id
        LEFT JOIN lookup_list_item_attributes lpattr ON lp.id = lpattr.item_id AND lpattr.attr_code = "COLOR-CLASS"
        LEFT JOIN lookup_list_items lc ON s.category_id = lc.id
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
if ($category !== '') {
  $sql .= ' AND s.category_id = :category';
  $params[':category'] = $category;
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
