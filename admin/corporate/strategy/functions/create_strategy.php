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

$title       = trim($_POST['title'] ?? '');
$corporateId = (int)($_POST['corporate_id'] ?? 1);
$statusId    = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
$priorityId  = $_POST['priority'] !== '' ? (int)$_POST['priority'] : null;
$categoryId  = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
$description = trim($_POST['description'] ?? '');
$targetStart = $_POST['target_start'] !== '' ? $_POST['target_start'] : null;
$targetEnd   = $_POST['target_end'] !== '' ? $_POST['target_end'] : null;
$tags        = trim($_POST['tags'] ?? '');

$validStatus   = array_column(get_lookup_items($pdo,'CORPORATE_STRATEGY_STATUS'),'id');
$validPriority = array_column(get_lookup_items($pdo,'CORPORATE_STRATEGY_PRIORITY'),'id');
$validCategory = array_column(get_lookup_items($pdo,'CORPORATE_STRATEGY_CATEGORY'),'id');

if ($statusId !== null && !in_array($statusId,$validStatus, true)) {
  echo json_encode(['success'=>false,'error'=>'Invalid status']);
  exit;
}
if ($priorityId !== null && !in_array($priorityId,$validPriority, true)) {
  echo json_encode(['success'=>false,'error'=>'Invalid priority']);
  exit;
}
if ($categoryId !== null && !in_array($categoryId,$validCategory, true)) {
  echo json_encode(['success'=>false,'error'=>'Invalid category']);
  exit;
}

if ($title === '') {
  echo json_encode(['success' => false, 'error' => 'Title is required']);
  exit;
}

try {
  $stmt = $pdo->prepare('INSERT INTO module_strategy (user_id,user_updated,corporate_id,title,description,status_id,priority_id,category_id,target_start,target_end) VALUES (:uid,:uid,:cid,:title,:description,:status,:priority,:category,:tstart,:tend)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':cid' => $corporateId,
    ':title' => $title,
    ':description' => $description !== '' ? $description : null,
    ':status' => $statusId,
    ':priority' => $priorityId,
    ':category' => $categoryId,
    ':tstart' => $targetStart,
    ':tend' => $targetEnd
  ]);
  $strategyId = (int)$pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_strategy', $strategyId, 'CREATE', null, json_encode(['title' => $title]));

  if ($tags !== '') {
    $insTag = $pdo->prepare('INSERT INTO module_strategy_tags (user_id,user_updated,strategy_id,tag) VALUES (:uid,:uid,:sid,:tag)');
    foreach (array_filter(array_map('trim', explode(',', $tags))) as $tag) {
      if ($tag === '') continue;
      $insTag->execute([
        ':uid' => $this_user_id,
        ':sid' => $strategyId,
        ':tag' => $tag
      ]);
    }
  }

  echo json_encode(['success' => true, 'id' => $strategyId]);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'error' => 'Database error']);
}
