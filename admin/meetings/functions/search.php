<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Query required']);
    exit;
}

// Fetch up to 20 meetings matching the query and include the total count
$stmt = $pdo->prepare(
    'SELECT id, title, start_time, COUNT(*) OVER () AS total FROM module_meetings WHERE title LIKE :q ORDER BY start_time DESC LIMIT 20'
);
$stmt->execute([':q' => "%" . $q . "%"]);
$meetings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $meetings[0]['total'] ?? 0;
foreach ($meetings as &$m) {
    $m['start_time'] = !empty($m['start_time']) ? date('d M, Y g:i A', strtotime($m['start_time'])) : '';
    unset($m['total']);
}
unset($m);

echo json_encode(['success' => true, 'meetings' => $meetings, 'count' => (int)$count]);

