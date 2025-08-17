<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
$note_id = isset($_POST['note_id']) && $_POST['note_id'] !== '' ? (int)$_POST['note_id'] : null;
$response = [];

if ($project_id && !empty($_FILES['file'])) {
    $uploadDir = '../uploads/';
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
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($files['tmp_name'][$index], $targetPath)) {
            $filePathDb = '/module/project/uploads/' . $targetName;
            $stmt = $pdo->prepare('INSERT INTO module_projects_files (user_id,user_updated,project_id,note_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:pid,:nid,:name,:path,:size,:type)');
            $stmt->execute([
                ':uid' => $this_user_id,
                ':pid' => $project_id,
                ':nid' => $note_id,
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
