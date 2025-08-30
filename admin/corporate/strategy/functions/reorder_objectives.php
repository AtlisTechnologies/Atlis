<?php
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'update');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request']);
  exit;
}
if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

$data = json_decode($_POST['hierarchy'] ?? '[]', true);
if (!is_array($data)) {
  echo json_encode(['success' => false, 'error' => 'Invalid data']);
  exit;
}

// collect all ids
$ids = [];
$collect = function (array $items) use (&$collect, &$ids) {
  foreach ($items as $i) {
    $ids[] = (int)$i['id'];
    if (!empty($i['children'])) {
      $collect($i['children']);
    }
  }
};
$collect($data);

if (!$ids) {
  echo json_encode(['success' => true]);
  exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$stmt = $pdo->prepare("SELECT id,parent_id,sort_order,strategy_id FROM module_strategy_objectives WHERE id IN ($placeholders)");
$stmt->execute($ids);
$existing = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $existing[$row['id']] = $row;
}
if (count($existing) !== count($ids)) {
  echo json_encode(['success' => false, 'error' => 'Invalid objective']);
  exit;
}
$strategyId = $existing[$ids[0]]['strategy_id'];

$update = $pdo->prepare('UPDATE module_strategy_objectives SET parent_id = :pid, sort_order = :sort, user_updated = :uid WHERE id = :id');
$fn = function (array $items, $parent) use (&$fn, $update, $existing, $strategyId, $pdo, $this_user_id) {
  $sort = 0;
  foreach ($items as $item) {
    $id = (int)$item['id'];
    if (!isset($existing[$id]) || $existing[$id]['strategy_id'] != $strategyId) {
      echo json_encode(['success' => false, 'error' => 'Invalid objective']);
      exit;
    }
    $pid = $parent ?: null;
    if ($pid && (!isset($existing[$pid]) || $existing[$pid]['strategy_id'] != $strategyId)) {
      echo json_encode(['success' => false, 'error' => 'Invalid parent']);
      exit;
    }
    $old = ['parent_id' => $existing[$id]['parent_id'], 'sort_order' => $existing[$id]['sort_order']];
    $update->execute([':pid' => $pid, ':sort' => $sort, ':uid' => $this_user_id, ':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'module_strategy_objectives', $id, 'REORDER', json_encode($old), json_encode(['parent_id' => $pid, 'sort_order' => $sort]));
    if (!empty($item['children'])) {
      $fn($item['children'], $id);
    }
    $sort++;
  }
};
$fn($data, 0);
echo json_encode(['success' => true]);
