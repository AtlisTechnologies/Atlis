<?php
require '../../../includes/php_header.php';
require_permission('project', 'update');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id            = (int)($_POST['id'] ?? 0);
  $name          = $_POST['name'] ?? '';
  $status        = $_POST['status'] ?? null;
  $type          = $_POST['type'] ?? null;
  $description   = $_POST['description'] ?? null;
  $requirements  = $_POST['requirements'] ?? null;
  $specifications = $_POST['specifications'] ?? null;
  $start_date    = $_POST['start_date'] ?? null;
  $agency_id     = $_POST['agency_id'] ?? null;
  $division_id   = $_POST['division_id'] ?? null;
  $is_private    = isset($_POST['is_private']) ? 1 : 0;

  $start_date  = $start_date !== '' ? $start_date : null;
  $agency_id   = $agency_id !== '' ? $agency_id : null;
  $division_id = $division_id !== '' ? $division_id : null;

  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_projects SET name = :name, status = :status, type = :type, description = :description, requirements = :requirements, specifications = :specifications, start_date = :start_date, agency_id = :agency_id, division_id = :division_id, is_private = :is_private, user_updated = :uid WHERE id = :id');
    $stmt->execute([
      ':uid' => $this_user_id,
      ':name' => $name,
      ':status' => $status,
      ':type' => $type,
      ':description' => $description,
      ':requirements' => $requirements,
      ':specifications' => $specifications,
      ':start_date' => $start_date,
      ':agency_id' => $agency_id,
      ':division_id' => $division_id,
      ':is_private' => $is_private,
      ':id' => $id
    ]);
    audit_log($pdo, $this_user_id, 'module_projects', $id, 'UPDATE', 'Updated project');
  }
}

header('Location: ../index.php?action=details&id=' . $id);
exit;

