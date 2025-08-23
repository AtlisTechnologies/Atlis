<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);

    if ($id && $meeting_id) {
        $pdo->prepare('DELETE FROM module_meeting_agenda WHERE id=:id AND meeting_id=:mid')->execute([':id' => $id, ':mid' => $meeting_id]);
        audit_log($pdo, $this_user_id, 'module_meeting_agenda', $id, 'DELETE', 'Deleted agenda item');
    }

    $listStmt = $pdo->prepare('SELECT id, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id FROM module_meeting_agenda WHERE meeting_id=? ORDER BY order_index');
    $listStmt->execute([$meeting_id]);
    $items = $listStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

echo json_encode(['success' => false]);
