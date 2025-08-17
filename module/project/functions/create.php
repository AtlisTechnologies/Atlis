<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('project', 'create');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $description = $_POST['description'] ?? null;
  $requirements = $_POST['requirements'] ?? null;
  $specifications = $_POST['specifications'] ?? null;
  $start_date = $_POST['start_date'] ?? null;
  $agency_id = $_POST['agency_id'] ?? null;
  $division_id = $_POST['division_id'] ?? null;

  $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, agency_id, division_id, name, description, requirements, specifications, status, start_date) VALUES (:uid, :uid, :agency_id, :division_id, :name, :description, :requirements, :specifications, :status, :start_date)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':agency_id' => $agency_id,
    ':division_id' => $division_id,
    ':name' => $name,
    ':description' => $description,
    ':requirements' => $requirements,
    ':specifications' => $specifications,
    ':status' => $status,
    ':start_date' => $start_date
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
      'agency_id' => $agency_id,
      'division_id' => $division_id,
      'name' => $name,
      'description' => $description,
      'requirements' => $requirements,
      'specifications' => $specifications,
      'status' => $status,
      'start_date' => $start_date
    ]),
    'Created project'
  );
}

header('Location: ../index.php?action=details&id=' . $id);
exit;
