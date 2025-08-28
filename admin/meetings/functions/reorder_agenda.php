<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $meeting_id = (int)($_POST['meeting_id'] ?? 0);
    $ids = isset($_POST['ids']) && is_array($_POST['ids']) ? array_map('intval', $_POST['ids']) : [];
    if (!$meeting_id || empty($ids)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data']);
        exit;
    }

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare('UPDATE module_meeting_agenda SET order_index=? WHERE id=? AND meeting_id=?');
        $i = 1;
        foreach ($ids as $id) {
            $stmt->execute([$i++, $id, $meeting_id]);
        }
        $pdo->commit();

        $listStmt = $pdo->prepare('SELECT id, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id FROM module_meeting_agenda WHERE meeting_id=? ORDER BY order_index');
        $listStmt->execute([$meeting_id]);
        $items = $listStmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'items' => $items]);
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
