<?php
require '../../../includes/php_header.php';
require_permission('project', 'delete');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  if ($id) {
    $stmt = $pdo->prepare('DELETE FROM module_projects WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_projects', $id, 'DELETE', 'Deleted project');
  }
}

header('Location: ../index.php');
exit;

