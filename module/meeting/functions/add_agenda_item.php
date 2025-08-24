<?php
require '../../../includes/php_header.php';
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
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);
    $order_index = (int)($_POST['order_index'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $status_id = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
    $linked_task_id = isset($_POST['linked_task_id']) && $_POST['linked_task_id'] !== '' ? (int)$_POST['linked_task_id'] : null;
    $linked_project_id = isset($_POST['linked_project_id']) && $_POST['linked_project_id'] !== '' ? (int)$_POST['linked_project_id'] : null;

    if ($meeting_id && $title !== '') {
        $stmt = $pdo->prepare('INSERT INTO module_meeting_agenda (user_id, user_updated, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id) VALUES (:uid,:uid,:mid,:order_index,:title,:status_id,:task_id,:project_id)');
        $stmt->execute([
            ':uid' => $this_user_id,
            ':mid' => $meeting_id,
            ':order_index' => $order_index,
            ':title' => $title,
            ':status_id' => $status_id,
            ':task_id' => $linked_task_id,
            ':project_id' => $linked_project_id
        ]);
        $id = $pdo->lastInsertId();
        audit_log($pdo, $this_user_id, 'module_meeting_agenda', $id, 'CREATE', 'Added agenda item');
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
