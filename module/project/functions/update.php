<?php
require '../../../includes/php_header.php';
require_permission('project', 'update');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $description = $_POST['description'] ?? null;

  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_projects SET name = :name, status = :status, description = :description, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':name' => $name,
      ':status' => $status,
      ':description' => $description,
      ':id' => $id
    ]);
    audit_log($pdo, $this_user_id, 'module_projects', $id, 'UPDATE', 'Updated project');
  }
}

header('Location: ../index.php?action=details&id=' . $id);
exit;

