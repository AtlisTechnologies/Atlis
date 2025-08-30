<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('project', 'create');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'] ?? '';
  $status   = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $type     = $_POST['type'] ?? null;
  $description = $_POST['description'] ?? null;
  $requirements = $_POST['requirements'] ?? null;
  $specifications = $_POST['specifications'] ?? null;
  $start_date = $_POST['start_date'] ?? null;
  $agency_id = $_POST['agency_id'] ?? null;
  $division_id = $_POST['division_id'] ?? null;
  $is_private = isset($_POST['is_private']) ? 1 : 0;

  if (!$agency_id && $division_id) {
    $stmt = $pdo->prepare('SELECT agency_id FROM module_division WHERE id = :id');
    $stmt->execute([':id' => $division_id]);
    $agency_id = $stmt->fetchColumn();
  }
  if (!$agency_id && !$division_id) {
    die('Agency or Division required');
  }

  $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, agency_id, division_id, is_private, name, description, requirements, specifications, status, priority, type, start_date) VALUES (:uid, :uid, :agency_id, :division_id, :is_private, :name, :description, :requirements, :specifications, :status, :priority, :type, :start_date)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':agency_id' => $agency_id,
    ':division_id' => $division_id,
    ':is_private' => $is_private,
    ':name' => $name,
    ':description' => $description,
    ':requirements' => $requirements,
    ':specifications' => $specifications,
    ':status' => $status,
    ':priority' => $priority,
    ':type' => $type,
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
      'is_private' => $is_private,
      'name' => $name,
      'description' => $description,
      'requirements' => $requirements,
      'specifications' => $specifications,
      'status' => $status,
      'priority' => $priority,
      'type' => $type,
      'start_date' => $start_date
    ]),
    'Created project'
  );
}

header('Location: ../index.php?action=details&id=' . $id);
exit;
