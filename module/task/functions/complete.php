<?php
require '../../../includes/php_header.php';
require_permission('task','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id > 0) {
    $stmt = $pdo->prepare('UPDATE module_tasks SET completed = 1, complete_date = NOW(), progress_percent = 100, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':id' => $id
    ]);
    audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Completed task');
    echo json_encode(['success' => true]);
    exit;
  }
}

echo json_encode(['success' => false]);
