<?php
require '../../../includes/php_header.php';
require_permission('project','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['pinned']) && is_array($_POST['pinned'])) {
        $order = 1;
        $stmt = $pdo->prepare('UPDATE module_projects_pins SET sort_order = :sort, user_updated = :uid WHERE user_id = :uid AND project_id = :pid');
        foreach ($_POST['pinned'] as $pid) {
            $pid = (int)$pid;
            $stmt->execute([
                ':sort' => $order++,
                ':uid' => $this_user_id,
                ':pid' => $pid
            ]);
        }
    }
    if (!empty($_POST['unpinned']) && is_array($_POST['unpinned'])) {
        $order = 1;
        $stmt = $pdo->prepare('INSERT INTO module_projects_sort (user_id,user_updated,project_id,sort_order) VALUES (:uid,:uid,:pid,:sort) ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order), user_updated = VALUES(user_updated)');
        foreach ($_POST['unpinned'] as $pid) {
            $pid = (int)$pid;
            $stmt->execute([
                ':uid' => $this_user_id,
                ':pid' => $pid,
                ':sort' => $order++
            ]);
        }
    }
}

echo json_encode(['success' => true]);
