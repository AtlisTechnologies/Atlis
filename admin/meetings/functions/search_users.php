<?php
require '../../../includes/php_header.php';
require_permission('person', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare('SELECT u.id, COALESCE(CONCAT(p.first_name, " ", p.last_name), CONCAT(u.first_name, " ", u.last_name)) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE COALESCE(CONCAT(p.first_name, " ", p.last_name), CONCAT(u.first_name, " ", u.last_name)) LIKE :q ORDER BY name LIMIT 10');
$stmt->execute([':q' => "%" . $q . "%"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
