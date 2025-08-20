<?php
require '../../../includes/php_header.php';
require_permission('kanban', 'update');

header('Content-Type: application/json');

$task_id = isset($_POST['task_id']) ? (int)$_POST['task_id'] : 0;
$status  = $_POST['status'] ?? '';

if ($task_id && $status) {
    $stmt = $pdo->prepare('UPDATE module_tasks SET status=?, user_updated=? WHERE id=?');
    $stmt->execute([$status, $this_user_id, $task_id]);
    echo json_encode(['success' => true]);
    exit;
}

http_response_code(400);
echo json_encode(['success' => false]);
