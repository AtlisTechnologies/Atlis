<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
if (!$project_id) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Missing project_id']);
    exit;
}
$note_id    = isset($_POST['note_id']) && $_POST['note_id'] !== '' ? (int)$_POST['note_id'] : null;
$description = trim($_POST['description'] ?? '');
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$status_id    = (int)($_POST['status_id'] ?? 0);
$sort_order   = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
$folder_id = isset($_POST['folder_id']) && $_POST['folder_id'] !== '' ? (int)$_POST['folder_id'] : null;
$response = [];

if (!$file_type_id) {
    $defaultType = array_filter(get_lookup_items($pdo, 'PROJECT_FILE_TYPE'), fn($i) => !empty($i['is_default']));
    $file_type_id = $defaultType ? array_values($defaultType)[0]['id'] : null;
}
if (!$status_id) {
    $defaultStatus = array_filter(get_lookup_items($pdo, 'PROJECT_FILE_STATUS'), fn($i) => !empty($i['is_default']));
    $status_id = $defaultStatus ? array_values($defaultStatus)[0]['id'] : null;
}

if (!empty($_FILES['file'])) {
    $maxMb = (int)get_system_property($pdo,'PROJECT_FILE_MAX_UPLOAD_MB');
    $maxSize = $maxMb ? $maxMb * 1024 * 1024 : 0;

    $folderPath = get_project_folder_path($pdo,$folder_id);
    $uploadDir = dirname(__DIR__) . '/uploads/' . $project_id . '/' . ($folderPath !== '' ? $folderPath . '/' : '');
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $files = $_FILES['file'];
    if (!is_array($files['name'])) {
        $files = [
            'name' => [$files['name']],
            'type' => [$files['type']],
            'tmp_name' => [$files['tmp_name']],
            'error' => [$files['error']],
            'size' => [$files['size']]
        ];
    }

    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] !== UPLOAD_ERR_OK) {
            continue;
        }
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
        $targetName = 'project_' . $project_id . '_' . time() . '_' . $safeName;
        if($maxSize && $files['size'][$index] > $maxSize){
            $response[] = ['name'=>$baseName,'error'=>'File too large'];
            continue;
        }
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($files['tmp_name'][$index], $targetPath)) {
            $filePathDb = '/module/project/uploads/' . $project_id . '/' . ($folderPath !== '' ? $folderPath . '/' : '') . $targetName;
            $stmt = $pdo->prepare('INSERT INTO module_projects_files (user_id,user_updated,project_id,folder_id,note_id,description,file_type_id,status_id,sort_order,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:pid,:fid,:nid,:description,:file_type_id,:status_id,:sort_order,:name,:path,:size,:type)');
            $stmt->execute([
                ':uid' => $this_user_id,
                ':pid' => $project_id,
                ':fid' => $folder_id,
                ':nid' => $note_id,
                ':description' => $description !== '' ? $description : null,
                ':file_type_id' => $file_type_id,
                ':status_id' => $status_id,
                ':sort_order' => $sort_order,
                ':name' => $baseName,
                ':path' => $filePathDb,
                ':size' => $files['size'][$index],
                ':type' => $files['type'][$index]
            ]);
            $fileId = $pdo->lastInsertId();
            admin_audit_log($pdo, $this_user_id, 'module_projects_files', $fileId, 'UPLOAD', '', json_encode(['file' => $baseName]));

            $response[] = [
                'id' => $fileId,
                'name' => $baseName,
                'path' => $filePathDb,
                'size' => $files['size'][$index],
                'type' => $files['type'][$index]
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode(['files' => $response]);
exit;
