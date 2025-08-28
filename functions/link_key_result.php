<?php
require '../includes/php_header.php';
require_permission('admin_business_strategy','update');
header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$taskId = isset($_POST['task_id']) && $_POST['task_id'] !== '' ? (int)$_POST['task_id'] : null;
$projectId = isset($_POST['project_id']) && $_POST['project_id'] !== '' ? (int)$_POST['project_id'] : null;

if (!$id || ($taskId === null && $projectId === null)) {
    echo json_encode(['success' => false]);
    exit;
}

if ($taskId !== null && !user_has_permission('task', 'read')) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}
if ($projectId !== null && !user_has_permission('project', 'read')) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}

$stmt = $pdo->prepare('UPDATE module_strategy_key_results SET task_id = :tid, project_id = :pid, user_updated = :uid WHERE id = :id');
$stmt->bindValue(':tid', $taskId, $taskId !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
$stmt->bindValue(':pid', $projectId, $projectId !== null ? PDO::PARAM_INT : PDO::PARAM_NULL);
$stmt->bindValue(':uid', $this_user_id, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
