<?php
require '../../../includes/php_header.php';
require_once '../../../includes/helpers.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

if (in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'], true)) {
    $req = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
    if (!verify_csrf_token($req['csrf_token'] ?? '')) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $meeting_id = (int)($req['meeting_id'] ?? 0);

    try {
        $files = [];
        if ($meeting_id) {
            $stmt = $pdo->prepare('SELECT id, file_name, file_path FROM module_meeting_files WHERE meeting_id = ? ORDER BY id');
            $stmt->execute([$meeting_id]);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $files[] = [
                    'id' => (int)$row['id'],
                    'name' => $row['file_name'],
                    'url' => getURLDir() . ltrim($row['file_path'], '/')
                ];
            }
        }
        echo json_encode(['success' => true, 'files' => $files]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
