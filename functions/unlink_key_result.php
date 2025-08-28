<?php
require '../includes/php_header.php';
require_permission('admin_strategy','update');
header('Content-Type: application/json');

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if (!$id) {
    echo json_encode(['success' => false]);
    exit;
}

$target = $_POST['target'] ?? '';
if ($target === 'task' && !user_has_permission('task','read')) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}
if ($target === 'project' && !user_has_permission('project','read')) {
    http_response_code(403);
    echo json_encode(['success' => false]);
    exit;
}

$fieldSql = $target === 'project' ? 'project_id' : 'task_id';
$stmt = $pdo->prepare("UPDATE module_strategy_key_results SET $fieldSql = NULL, user_updated = :uid WHERE id = :id");
$stmt->bindValue(':uid', $this_user_id, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$success = $stmt->execute();

echo json_encode(['success' => $success]);
