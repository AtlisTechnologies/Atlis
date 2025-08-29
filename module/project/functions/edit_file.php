<?php
require '../../../includes/php_header.php';
require_permission('project','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }
$id         = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);
$description = trim($_POST['description'] ?? '');
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$status_id    = (int)($_POST['status_id'] ?? 0);
$sort_order   = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
$folder_id    = isset($_POST['folder_id']) && $_POST['folder_id'] !== '' ? (int)$_POST['folder_id'] : null;

if ($id && $project_id) {
    $stmt = $pdo->prepare('SELECT user_id, description, file_type_id, status_id, sort_order, folder_id, file_path, file_name FROM module_projects_files WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($current && (user_has_permission('project','update') || $is_admin || $current['user_id'] == $this_user_id)) {
        $newPath = $current['file_path'];
        if($folder_id !== null && $folder_id != $current['folder_id']){
            $folderPath = get_project_folder_path($pdo,$folder_id);
            $baseDir = dirname(__DIR__,3);
            $oldFull = $baseDir . $current['file_path'];
            $newRel = '/module/project/uploads/' . $project_id . '/' . ($folderPath !== '' ? $folderPath . '/' : '') . basename($current['file_path']);
            $newFull = $baseDir . $newRel;
            if(!is_dir(dirname($newFull))){ mkdir(dirname($newFull),0777,true); }
            if(@rename($oldFull,$newFull)){
                $newPath = $newRel;
            } else {
                $folder_id = $current['folder_id'];
            }
        } else {
            $folder_id = $current['folder_id'];
        }
        $pdo->prepare('UPDATE module_projects_files SET description = :description, file_type_id = :file_type_id, status_id = :status_id, sort_order = :sort_order, folder_id = :folder_id, file_path = :path, user_updated = :uid WHERE id = :id')
            ->execute([
                ':description' => $description !== '' ? $description : null,
                ':file_type_id' => $file_type_id ?: null,
                ':status_id' => $status_id ?: null,
                ':sort_order' => $sort_order,
                ':folder_id' => $folder_id,
                ':path' => $newPath,
                ':uid' => $this_user_id,
                ':id' => $id
            ]);
        admin_audit_log($pdo, $this_user_id, 'module_projects_files', $id, 'UPDATE', json_encode($current), json_encode([
            'description' => $description !== '' ? $description : null,
            'file_type_id' => $file_type_id ?: null,
            'status_id' => $status_id ?: null,
            'sort_order' => $sort_order,
            'folder_id' => $folder_id,
            'file_path' => $newPath
        ]));
    } else {
        header('HTTP/1.1 403 Forbidden');
        exit;
    }
}

header('Location: ../index.php?action=details&id=' . $project_id);

