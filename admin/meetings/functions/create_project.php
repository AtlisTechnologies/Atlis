<?php
require '../../../includes/php_header.php';
require_permission('project', 'create');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$name         = trim($_POST['name'] ?? '');
$status_id    = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
$priority_id  = isset($_POST['priority_id']) && $_POST['priority_id'] !== '' ? (int)$_POST['priority_id'] : null;
$type_id      = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
$description  = $_POST['description'] ?? null;
$requirements = $_POST['requirements'] ?? null;
$specifications = $_POST['specifications'] ?? null;
$start_date   = $_POST['start_date'] ?? null;
$complete_date = $_POST['complete_date'] ?? null;
$completed    = !empty($_POST['completed']) ? 1 : 0;
$agency_id    = isset($_POST['agency_id']) && $_POST['agency_id'] !== '' ? (int)$_POST['agency_id'] : null;
$division_id  = isset($_POST['division_id']) && $_POST['division_id'] !== '' ? (int)$_POST['division_id'] : null;
$is_private   = !empty($_POST['is_private']) ? 1 : 0;

$errors = [];
if ($name === '') {
    $errors[] = 'Project name is required';
}

if ($start_date) {
    $dt = DateTime::createFromFormat('Y-m-d', $start_date);
    if ($dt) {
        $start_date = $dt->format('Y-m-d');
    } else {
        $errors[] = 'Invalid start date';
    }
} else {
    $start_date = null;
}

if ($complete_date) {
    $cdt = DateTime::createFromFormat('Y-m-d', $complete_date);
    if ($cdt) {
        $complete_date = $cdt->format('Y-m-d');
    } else {
        $errors[] = 'Invalid complete date';
    }
} else {
    $complete_date = null;
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode('; ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO module_projects (user_id, user_updated, agency_id, division_id, is_private, name, description, requirements, specifications, status, priority, type, start_date, complete_date, completed) VALUES (:uid,:uid,:agency_id,:division_id,:is_private,:name,:description,:requirements,:specifications,:status_id,:priority_id,:type_id,:start_date,:complete_date,:completed)');
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
        ':start_date' => $start_date,
        ':complete_date' => $complete_date,
        ':completed' => $completed
    ]);
    $project_id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_projects', $project_id, 'CREATE', null, json_encode(['name' => $name]), 'Created project from meeting');
    echo json_encode(['success' => true, 'project_id' => $project_id, 'message' => 'Project created']);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
