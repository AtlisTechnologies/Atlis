<?php
require '../../../includes/php_header.php';

$id         = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);
$description = trim($_POST['description'] ?? '');
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$status_id    = (int)($_POST['status_id'] ?? 0);
$sort_order   = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

if ($id && $project_id) {
    $stmt = $pdo->prepare('SELECT user_id, description, file_type_id, status_id, sort_order FROM module_projects_files WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($current && (user_has_permission('project','update') || $is_admin || $current['user_id'] == $this_user_id)) {
        $pdo->prepare('UPDATE module_projects_files SET description = :description, file_type_id = :file_type_id, status_id = :status_id, sort_order = :sort_order, user_updated = :uid WHERE id = :id')
            ->execute([
                ':description' => $description !== '' ? $description : null,
                ':file_type_id' => $file_type_id ?: null,
                ':status_id' => $status_id ?: null,
                ':sort_order' => $sort_order,
                ':uid' => $this_user_id,
                ':id' => $id
            ]);
        admin_audit_log($pdo, $this_user_id, 'module_projects_files', $id, 'UPDATE', json_encode($current), json_encode([
            'description' => $description !== '' ? $description : null,
            'file_type_id' => $file_type_id ?: null,
            'status_id' => $status_id ?: null,
            'sort_order' => $sort_order
        ]));
    } else {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
}

header('Location: ../index.php?action=details&id=' . $project_id);
exit;
