<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);
$description = trim($_POST['description'] ?? '');
$file_type_code = $_POST['file_type_code'] ?? null;
$file_status_code = $_POST['file_status_code'] ?? null;
$sort_order = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : null;

if ($id && $project_id) {
    $stmt = $pdo->prepare('SELECT user_id, description, file_type_code, file_status_code, sort_order FROM module_projects_files WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && ($is_admin || $row['user_id'] == $this_user_id)) {
        $upd = $pdo->prepare('UPDATE module_projects_files SET description = :description, file_type_code = :type, file_status_code = :status, sort_order = :sort, user_updated = :uid WHERE id = :id');
        $upd->execute([
            ':description' => $description,
            ':type' => $file_type_code,
            ':status' => $file_status_code,
            ':sort' => $sort_order,
            ':uid' => $this_user_id,
            ':id' => $id
        ]);
        admin_audit_log($pdo, $this_user_id, 'module_projects_files', $id, 'UPDATE', json_encode($row), json_encode(['description'=>$description,'file_type_code'=>$file_type_code,'file_status_code'=>$file_status_code,'sort_order'=>$sort_order]));
    }
}
header('Location: ../index.php?action=details&id=' . $project_id);
exit;
?>
