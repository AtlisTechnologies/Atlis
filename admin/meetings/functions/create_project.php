<?php
require '../../../includes/php_header.php';
require_permission('project', 'create');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $status_id   = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
    $priority_id = isset($_POST['priority_id']) && $_POST['priority_id'] !== '' ? (int)$_POST['priority_id'] : null;
    $type_id     = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
    $description = $_POST['description'] ?? null;
    $requirements = $_POST['requirements'] ?? null;
    $specifications = $_POST['specifications'] ?? null;
    $start_date = $_POST['start_date'] ?? null;
    $agency_id = isset($_POST['agency_id']) && $_POST['agency_id'] !== '' ? (int)$_POST['agency_id'] : null;
    $division_id = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? (int)$_POST['division_id'] : null;
    $is_private = !empty($_POST['is_private']) ? 1 : 0;

    if ($name === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Project name is required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, agency_id, division_id, is_private, name, description, requirements, specifications, status, priority, type, start_date) VALUES (:uid,:uid,:agency_id,:division_id,:is_private,:name,:description,:requirements,:specifications,:status_id,:priority_id,:type_id,:start_date)');
        $stmt->execute([
            ':uid' => $this_user_id,
            ':agency_id' => $agency_id,
            ':division_id' => $division_id,
            ':is_private' => $is_private,
            ':name' => $name,
            ':description' => $description,
            ':requirements' => $requirements,
            ':specifications' => $specifications,
            ':status_id' => $status_id,
            ':priority_id' => $priority_id,
            ':type_id' => $type_id,
            ':start_date' => $start_date
        ]);
        $project_id = $pdo->lastInsertId();
        admin_audit_log($pdo, $this_user_id, 'module_projects', $project_id, 'CREATE', null, json_encode(['name' => $name]), 'Created project from meeting');
        echo json_encode(['success' => true, 'project_id' => $project_id, 'message' => 'Project created']);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Invalid request']);
