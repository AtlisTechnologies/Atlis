<?php
require '../../../includes/php_header.php';
require_permission('person', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare('SELECT p.id, CONCAT(p.first_name, " ", p.last_name) AS name, p.user_id FROM person p WHERE CONCAT(p.first_name, " ", p.last_name) LIKE :q ORDER BY name LIMIT 10');
$stmt->execute([':q' => "%" . $q . "%"]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

