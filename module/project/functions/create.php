<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('project', 'create');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $description = $_POST['description'] ?? null;

  $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, name, status, description) VALUES (:uid, :uid, :name, :status, :description)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':name' => $name,
    ':status' => $status,
    ':description' => $description
  ]);
  $id = $pdo->lastInsertId();

  admin_audit_log(
    $pdo,
    $this_user_id,
    'module_projects',
    $id,
    'CREATE',
    null,
    json_encode([
      'name' => $name,
      'status' => $status,
      'description' => $description
    ]),
    'Created project'
  );
}

header('Location: index.php');
exit;
