<?php
require '../../../includes/php_header.php';
require_permission('task', 'create');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$name = trim($_POST['name'] ?? '');
$project_id = isset($_POST['project_id']) ? (int)$_POST['project_id'] : 0;
$status = trim($_POST['status'] ?? '');
$priority = trim($_POST['priority'] ?? '');
$start_date = $_POST['start_date'] ?? '';
$due_date = $_POST['due_date'] ?? '';

$errors = [];
if ($name === '' || strlen($name) > 255) {
    $errors[] = 'Valid name required';
}
if ($project_id <= 0) {
    $errors[] = 'Valid project_id required';
}
if ($status === '' || strlen($status) > 11) {
    $errors[] = 'Valid status required';
}
if ($priority === '' || strlen($priority) > 11) {
    $errors[] = 'Valid priority required';
}
$start_dt = DateTime::createFromFormat('Y-m-d', $start_date);
if (!$start_dt) {
    $errors[] = 'Invalid start_date';
}
$due_dt = DateTime::createFromFormat('Y-m-d', $due_date);
if (!$due_dt) {
    $errors[] = 'Invalid due_date';
}
if ($start_dt && $due_dt && $due_dt < $start_dt) {
    $errors[] = 'Due date must be after start date';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode('; ', $errors)]);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, user_updated, project_id, name, status, priority, start_date, due_date) VALUES (:uid,:uid,:project_id,:name,:status,:priority,:start_date,:due_date)');
    $stmt->execute([
        ':uid' => $this_user_id,
        ':project_id' => $project_id,
        ':name' => $name,
        ':status' => $status,
        ':priority' => $priority,
        ':start_date' => $start_dt->format('Y-m-d'),
        ':due_date' => $due_dt->format('Y-m-d')
    ]);
    $task_id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_tasks', $task_id, 'CREATE', '', json_encode(['name' => $name]), 'Created task');
    echo json_encode(['success' => true, 'task_id' => $task_id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
