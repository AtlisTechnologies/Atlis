<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../../includes/php_header.php';
require_permission('admin_task','update');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit;
}

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
  die('Invalid CSRF token');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
  die('Invalid ID');
}

$oldStmt = $pdo->prepare('SELECT * FROM admin_task WHERE id = :id');
$oldStmt->execute([':id' => $id]);
$old = $oldStmt->fetch(PDO::FETCH_ASSOC);

$name = trim($_POST['name'] ?? '');
$description = $_POST['description'] ?? null;
$type_id = $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
$category_id = $_POST['category_id'] !== '' ? (int)$_POST['category_id'] : null;
$sub_category_id = $_POST['sub_category_id'] !== '' ? (int)$_POST['sub_category_id'] : null;
$status_id = $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$priority_id = $_POST['priority_id'] !== '' ? (int)$_POST['priority_id'] : null;
$start_date = $_POST['start_date'] ?? null;
$due_date = $_POST['due_date'] ?? null;
$memo = $_POST['memo'] ?? null;
$assigned_user_ids = isset($_POST['assignments']) ? array_map('intval', (array)$_POST['assignments']) : [];

$pdo->prepare('UPDATE admin_task SET name=:name, description=:description, type_id=:type_id, category_id=:category_id, sub_category_id=:sub_category_id, status_id=:status_id, priority_id=:priority_id, start_date=:start_date, due_date=:due_date, memo=:memo, user_updated=:uid WHERE id=:id')
    ->execute([
      ':name' => $name,
      ':description' => $description,
      ':type_id' => $type_id,
      ':category_id' => $category_id,
      ':sub_category_id' => $sub_category_id,
      ':status_id' => $status_id,
      ':priority_id' => $priority_id,
      ':start_date' => $start_date ?: null,
      ':due_date' => $due_date ?: null,
      ':memo' => $memo,
      ':uid' => $this_user_id,
      ':id' => $id
    ]);

$pdo->prepare('DELETE FROM admin_task_assignments WHERE task_id = :id')->execute([':id' => $id]);
foreach ($assigned_user_ids as $assigned_user_id) {
  $pdo->prepare('INSERT INTO admin_task_assignments (task_id, assigned_user_id, user_id, user_updated) VALUES (:task_id, :assigned_user_id, :uid, :uid)')
      ->execute([
        ':task_id' => $id,
        ':assigned_user_id' => $assigned_user_id,
        ':uid' => $this_user_id
      ]);
}

admin_audit_log($pdo, $this_user_id, 'admin_task', $id, 'UPDATE', json_encode($old), json_encode(['name'=>$name]), 'Updated task');

header('Location: ../task.php?id=' . $id);
