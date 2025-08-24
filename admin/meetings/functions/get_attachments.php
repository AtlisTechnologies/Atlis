<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$meeting_id = (int)($_GET['meeting_id'] ?? 0);

if ($meeting_id) {
    $stmt = $pdo->prepare('SELECT id, file_name, file_path FROM module_meeting_files WHERE meeting_id = ? ORDER BY id');
    $stmt->execute([$meeting_id]);
    $files = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $files[] = [
            'id' => (int)$row['id'],
            'name' => $row['file_name'],
            'url' => $row['file_path']
        ];
    }
    echo json_encode(['success' => true, 'files' => $files]);
    exit;
}

echo json_encode(['success' => false, 'files' => []]);
