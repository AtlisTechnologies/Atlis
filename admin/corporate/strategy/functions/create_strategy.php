<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'create');
header('Content-Type: application/json');

$title = trim($_POST['title'] ?? '');
$corporateId = (int)($_POST['corporate_id'] ?? 1);
$statusId = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
$priorityId = $_POST['priority'] !== '' ? (int)$_POST['priority'] : null;
$description = trim($_POST['description'] ?? '');
$targetStart = $_POST['target_start'] ?? null;
$targetEnd = $_POST['target_end'] ?? null;
$tags = trim($_POST['tags'] ?? '');

if ($title === '') {
  echo json_encode(['success' => false, 'error' => 'Title is required']);
  exit;
}

try {
  $stmt = $pdo->prepare('INSERT INTO module_strategy (user_id,user_updated,corporate_id,title,description,status_id,priority_id,target_start,target_end) VALUES (:uid,:uid,:cid,:title,:description,:status,:priority,:tstart,:tend)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':cid' => $corporateId,
    ':title' => $title,
    ':description' => $description !== '' ? $description : null,
    ':status' => $statusId,
    ':priority' => $priorityId,
    ':tstart' => $targetStart,
    ':tend' => $targetEnd
  ]);
  $strategyId = (int)$pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_strategy',$strategyId,'CREATE',null,null,json_encode(['title'=>$title]));

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
