<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting','update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $meeting_id = (int)($_POST['meeting_id'] ?? 0);
    if (!$meeting_id) {
        echo json_encode(['success' => false, 'message' => 'Missing meeting_id']);
        exit;
    }

    $response = [];

    try {
        if (!empty($_FILES['file'])) {
            $uploadDir = dirname(__DIR__) . '/uploads/' . $meeting_id . '/';
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
                    $filePathDb = '/admin/meetings/uploads/' . $meeting_id . '/' . $targetName;
                    $stmt = $pdo->prepare('INSERT INTO module_meeting_files (user_id,user_updated,meeting_id,file_name,file_path,uploader_id) VALUES (:uid,:uid,:mid,:name,:path,:uid)');
                    $stmt->execute([
                        ':uid' => $this_user_id,
                        ':mid' => $meeting_id,
                        ':name' => $baseName,
                        ':path' => $filePathDb
                    ]);
                    $fileId = $pdo->lastInsertId();
                    admin_audit_log($pdo, $this_user_id, 'module_meeting_files', $fileId, 'UPLOAD', '', json_encode(['file' => $baseName]));

                    $response[] = [
                        'id' => $fileId,
                        'name' => $baseName,
                        'url' => getURLDir() . ltrim($filePathDb, '/')
                    ];
                }
            }
            finfo_close($finfo);
        }

        echo json_encode(['success' => true, 'data' => $response]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
