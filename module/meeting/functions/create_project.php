<?php
require '../../../includes/php_header.php';
require_permission('project', 'create');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $status   = isset($_POST['status']) && $_POST['status'] !== '' ? $_POST['status'] : null;
    $priority = isset($_POST['priority']) && $_POST['priority'] !== '' ? $_POST['priority'] : null;
    $type     = isset($_POST['type']) && $_POST['type'] !== '' ? $_POST['type'] : null;
    $description = $_POST['description'] ?? null;
    $requirements = $_POST['requirements'] ?? null;
    $specifications = $_POST['specifications'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $agency_id = isset($_POST['agency_id']) && $_POST['agency_id'] !== '' ? $_POST['agency_id'] : null;
    $division_id = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? $_POST['division_id'] : null;
    $is_private = !empty($_POST['is_private']) ? 1 : 0;

    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, agency_id, division_id, is_private, name, description, requirements, specifications, status, priority, type, start_date) VALUES (:uid,:uid,:agency_id,:division_id,:is_private,:name,:description,:requirements,:specifications,:status,:priority,:type,:start_date)');
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
        admin_audit_log($pdo, $this_user_id, 'module_projects', $id, 'CREATE', null, json_encode(['name' => $name]), 'Created project from meeting');
        echo json_encode(['success' => true, 'id' => $id]);
        exit;
    }
}

echo json_encode(['success' => false]);
