<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_task', 'read');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token']);
    exit;
}

$stmt = $pdo->query('SELECT id, name, start_date, due_date FROM admin_task ORDER BY start_date');
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tasks = [];
foreach ($rows as $row) {
    $tasks[] = [
        'id' => (int)$row['id'],
        'name' => $row['name'],
        'start_date' => $row['start_date'] ? date('Y-m-d', strtotime($row['start_date'])) : null,
        'due_date' => $row['due_date'] ? date('Y-m-d', strtotime($row['due_date'])) : null,
    ];
}

echo json_encode(['tasks' => $tasks]);
