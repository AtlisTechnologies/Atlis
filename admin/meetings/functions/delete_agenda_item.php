<?php
require '../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

function reorder_agenda($pdo, $meeting_id){
    $stmt = $pdo->prepare('SELECT id FROM module_meeting_agenda WHERE meeting_id=? ORDER BY order_index, id');
    $stmt->execute([$meeting_id]);
    $i = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pdo->prepare('UPDATE module_meeting_agenda SET order_index=? WHERE id=?')->execute([$i++, $row['id']]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);

    if ($id && $meeting_id) {
        $pdo->prepare('DELETE FROM module_meeting_agenda WHERE id=:id AND meeting_id=:mid')->execute([':id' => $id, ':mid' => $meeting_id]);
        admin_audit_log($pdo, $this_user_id, 'module_meeting_agenda', $id, 'DELETE', 'Deleted agenda item');
        reorder_agenda($pdo, $meeting_id);
    } elseif ($meeting_id) {
        reorder_agenda($pdo, $meeting_id);
    }

    $listStmt = $pdo->prepare('SELECT id, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id FROM module_meeting_agenda WHERE meeting_id=? ORDER BY order_index');
    $listStmt->execute([$meeting_id]);
    $items = $listStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

echo json_encode(['success' => false]);
