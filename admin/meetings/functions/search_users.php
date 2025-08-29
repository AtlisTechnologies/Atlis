<?php
require '../../../includes/php_header.php';
require_permission('person', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT u.id, COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) AS name FROM users u JOIN person p ON u.id = p.user_id WHERE COALESCE(CONCAT(p.first_name, " ", p.last_name), u.email) LIKE :q ORDER BY name LIMIT 10');
    $stmt->execute([':q' => "%" . $q . "%"]);

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
