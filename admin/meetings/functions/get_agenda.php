<?php
require '../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$meeting_id = (int)($_GET['meeting_id'] ?? 0);

if ($meeting_id) {
    $stmt = $pdo->prepare('SELECT id, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id FROM module_meeting_agenda WHERE meeting_id = ? ORDER BY order_index');
    $stmt->execute([$meeting_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

echo json_encode(['success' => false, 'items' => []]);
