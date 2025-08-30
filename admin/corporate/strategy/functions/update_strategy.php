<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_strategy', 'update');
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

$title       = isset($_POST['title']) ? trim($_POST['title']) : null;
$statusId    = array_key_exists('status', $_POST)      ? ($_POST['status'] !== '' ? (int)$_POST['status'] : null) : null;
$priorityId  = array_key_exists('priority', $_POST)    ? ($_POST['priority'] !== '' ? (int)$_POST['priority'] : null) : null;
$categoryId  = array_key_exists('category_id', $_POST) ? ($_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null) : null;
$description = array_key_exists('description', $_POST) ? trim($_POST['description']) : null;
$targetStart = array_key_exists('target_start', $_POST) ? ($_POST['target_start'] !== '' ? $_POST['target_start'] : null) : null;
$targetEnd   = array_key_exists('target_end', $_POST) ? ($_POST['target_end'] !== '' ? $_POST['target_end'] : null) : null;
$tags        = isset($_POST['tags']) ? trim($_POST['tags']) : null;

$validStatus   = array_column(get_lookup_items($pdo, 'CORPORATE_STRATEGY_STATUS'), 'id');
$validPriority = array_column(get_lookup_items($pdo, 'CORPORATE_STRATEGY_PRIORITY'), 'id');
$validCategory = array_column(get_lookup_items($pdo, 'CORPORATE_STRATEGY_CATEGORY'), 'id');

if ($statusId !== null && !in_array($statusId, $validStatus, true)) {
  echo json_encode(['success' => false, 'error' => 'Invalid status']);
  exit;
}
if ($priorityId !== null && !in_array($priorityId, $validPriority, true)) {
  echo json_encode(['success' => false, 'error' => 'Invalid priority']);
  exit;
}
if ($categoryId !== null && !in_array($categoryId, $validCategory, true)) {
  echo json_encode(['success' => false, 'error' => 'Invalid category']);
  exit;
}

$fields = [];
$params = [':id' => $id, ':uid' => $this_user_id];
$changes = [];

if ($title !== null) {
  $fields[] = 'title = :title';
  $params[':title'] = $title;
  $changes['title'] = $title;
}
if (array_key_exists('description', $_POST)) {
  $fields[] = 'description = :description';
  $params[':description'] = ($description !== '' ? $description : null);
  $changes['description'] = $params[':description'];
}
if (array_key_exists('status', $_POST)) {
  if ($statusId === null) {
    $fields[] = 'status_id = NULL';
    $changes['status_id'] = null;
  } else {
    $fields[] = 'status_id = :status';
    $params[':status'] = $statusId;
    $changes['status_id'] = $statusId;
  }
}
if (array_key_exists('priority', $_POST)) {
  if ($priorityId === null) {
    $fields[] = 'priority_id = NULL';
    $changes['priority_id'] = null;
  } else {
    $fields[] = 'priority_id = :priority';
    $params[':priority'] = $priorityId;
    $changes['priority_id'] = $priorityId;
  }
}
if (array_key_exists('category_id', $_POST)) {
  if ($categoryId === null) {
    $fields[] = 'category_id = NULL';
    $changes['category_id'] = null;
  } else {
    $fields[] = 'category_id = :category';
    $params[':category'] = $categoryId;
    $changes['category_id'] = $categoryId;
  }
}
if (array_key_exists('target_start', $_POST)) {
  if ($targetStart === null) {
    $fields[] = 'target_start = NULL';
    $changes['target_start'] = null;
  } else {
    $fields[] = 'target_start = :tstart';
    $params[':tstart'] = $targetStart;
    $changes['target_start'] = $targetStart;
  }
}
if (array_key_exists('target_end', $_POST)) {
  if ($targetEnd === null) {
    $fields[] = 'target_end = NULL';
    $changes['target_end'] = null;
  } else {
    $fields[] = 'target_end = :tend';
    $params[':tend'] = $targetEnd;
    $changes['target_end'] = $targetEnd;
  }
}

if ($fields) {
  $sql = 'UPDATE module_strategy SET ' . implode(',', $fields) . ', user_updated = :uid WHERE id = :id';
  $upd = $pdo->prepare($sql);
  $upd->execute($params);
}

if ($tags !== null) {
  $pdo->prepare('DELETE FROM module_strategy_tags WHERE strategy_id = :id')->execute([':id' => $id]);
  if ($tags !== '') {
    $ins = $pdo->prepare('INSERT INTO module_strategy_tags (user_id,user_updated,strategy_id,tag) VALUES (:uid,:uid,:sid,:tag)');
    foreach (array_filter(array_map('trim', explode(',', $tags))) as $tag) {
      if ($tag === '') continue;
      $ins->execute([':uid' => $this_user_id, ':sid' => $id, ':tag' => $tag]);
    }
  }
}

admin_audit_log($pdo, $this_user_id, 'module_strategy', $id, 'UPDATE', json_encode($existing), json_encode($changes), 'Updated strategy');

echo json_encode(['success' => true]);

