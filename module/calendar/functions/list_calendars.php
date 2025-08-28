<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query('SELECT id, name FROM module_calendar WHERE is_private = 0 ORDER BY name');
    $cals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cals);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
