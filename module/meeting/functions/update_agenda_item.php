<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $meeting_id = (int)($_POST['meeting_id'] ?? 0);
    $order_index = (int)($_POST['order_index'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $status_id = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
    $linked_task_id = isset($_POST['linked_task_id']) && $_POST['linked_task_id'] !== '' ? (int)$_POST['linked_task_id'] : null;
    $linked_project_id = isset($_POST['linked_project_id']) && $_POST['linked_project_id'] !== '' ? (int)$_POST['linked_project_id'] : null;

    if ($id && $meeting_id) {
        $stmt = $pdo->prepare('UPDATE module_meeting_agenda SET user_updated=:uid, order_index=:order_index, title=:title, status_id=:status_id, linked_task_id=:task_id, linked_project_id=:project_id WHERE id=:id AND meeting_id=:mid');
        $stmt->execute([
            ':uid' => $this_user_id,
            ':order_index' => $order_index,
            ':title' => $title,
            ':status_id' => $status_id,
            ':task_id' => $linked_task_id,
            ':project_id' => $linked_project_id,
            ':id' => $id,
            ':mid' => $meeting_id
        ]);
        audit_log($pdo, $this_user_id, 'module_meeting_agenda', $id, 'UPDATE', 'Updated agenda item');
    }

    $listStmt = $pdo->prepare('SELECT id, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id FROM module_meeting_agenda WHERE meeting_id=? ORDER BY order_index');
    $listStmt->execute([$meeting_id]);
    $items = $listStmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

echo json_encode(['success' => false]);
