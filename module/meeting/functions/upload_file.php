<?php
require '../../../includes/php_header.php';
require_permission('meeting','update');

$meeting_id = (int)($_POST['meeting_id'] ?? 0);
if (!$meeting_id) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Missing meeting_id']);
    exit;
}

$note_id    = isset($_POST['note_id']) && $_POST['note_id'] !== '' ? (int)$_POST['note_id'] : null;
$description = trim($_POST['description'] ?? '');
$file_type_id = (int)($_POST['file_type_id'] ?? 0);
$status_id    = (int)($_POST['status_id'] ?? 0);
$sort_order   = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;
$response = [];

if (!$file_type_id) {
    $defaultType = array_filter(get_lookup_items($pdo, 'MEETING_FILE_TYPE'), fn($i) => !empty($i['is_default']));
    $file_type_id = $defaultType ? array_values($defaultType)[0]['id'] : null;
}
if (!$status_id) {
    $defaultStatus = array_filter(get_lookup_items($pdo, 'MEETING_FILE_STATUS'), fn($i) => !empty($i['is_default']));
    $status_id = $defaultStatus ? array_values($defaultStatus)[0]['id'] : null;
}

if (!empty($_FILES['file'])) {
    $uploadDir = '../uploads/' . $meeting_id . '/';
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

    $allowedImages = array_column(get_lookup_items($pdo, 'IMAGE_FILE_TYPES'), 'code');
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    foreach ($files['name'] as $index => $name) {
        if ($files['error'][$index] !== UPLOAD_ERR_OK) {
            continue;
        }
        $mime = finfo_file($finfo, $files['tmp_name'][$index]);
        if (strpos($mime, 'image/') === 0 && !in_array($mime, $allowedImages, true)) {
            continue;
        }
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
        $targetName = 'meeting_' . $meeting_id . '_' . time() . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($files['tmp_name'][$index], $targetPath)) {
            $filePathDb = '/module/meeting/uploads/' . $meeting_id . '/' . $targetName;
            $stmt = $pdo->prepare('INSERT INTO module_meeting_files (user_id,user_updated,meeting_id,note_id,description,file_type_id,status_id,sort_order,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:mid,:nid,:description,:file_type_id,:status_id,:sort_order,:name,:path,:size,:type)');
            $stmt->execute([
                ':uid' => $this_user_id,
                ':mid' => $meeting_id,
                ':nid' => $note_id,
                ':description' => $description !== '' ? $description : null,
                ':file_type_id' => $file_type_id,
                ':status_id' => $status_id,
                ':sort_order' => $sort_order,
                ':name' => $baseName,
                ':path' => $filePathDb,
                ':size' => $files['size'][$index],
                ':type' => $mime
            ]);
            $fileId = $pdo->lastInsertId();
            admin_audit_log($pdo, $this_user_id, 'module_meeting_files', $fileId, 'UPLOAD', '', json_encode(['file' => $baseName]));

            $response[] = [
                'id' => $fileId,
                'name' => $baseName,
                'path' => $filePathDb,
                'size' => $files['size'][$index],
                'type' => $mime
            ];
        }
    }
    finfo_close($finfo);
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'files' => $response]);
exit;
