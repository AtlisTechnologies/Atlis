<?php
require '../../../includes/php_header.php';
require_permission('task','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$isAjax = isset($_POST['ajax']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
if ($isAjax) {
  header('Content-Type: application/json');
}

$task_id = (int)($_POST['task_id'] ?? 0);
$user_id = (int)($_POST['user_id'] ?? 0);

$success = false;
$assignee = [];
if ($task_id && $user_id) {
  $check = $pdo->prepare('SELECT id FROM module_task_assignments WHERE task_id = :tid AND assigned_user_id = :uid');
  $check->execute([':tid' => $task_id, ':uid' => $user_id]);
  if (!$check->fetchColumn()) {
    $ins = $pdo->prepare('INSERT INTO module_task_assignments (user_id,user_updated,task_id,assigned_user_id) VALUES (:uid,:uid,:tid,:aid)');
    $ins->execute([':uid' => $this_user_id, ':tid' => $task_id, ':aid' => $user_id]);
    $assignId = $pdo->lastInsertId();
    audit_log($pdo, $this_user_id, 'module_task_assignments', $assignId, 'ASSIGN', 'Assigned user');
  }
  $uStmt = $pdo->prepare('SELECT upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS name FROM users u LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
  $uStmt->execute([':id' => $user_id]);
  $assignee = $uStmt->fetch(PDO::FETCH_ASSOC) ?: [];
  $assignee['assigned_user_id'] = $user_id;
  $success = true;
}

if ($isAjax) {
  echo json_encode(['success' => $success, 'assignee' => $assignee]);
  exit;
}

$redirect = $_POST['redirect'] ?? ('../index.php?action=details&id=' . $task_id);
header('Location: ' . $redirect);
exit;
