<?php
require '../../../includes/php_header.php';
require_permission('task', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare('SELECT id, name AS title FROM module_tasks WHERE (is_private = 0 OR user_id = :uid) AND name LIKE :q ORDER BY name LIMIT 10');
$stmt->execute([
    ':uid' => $this_user_id,
    ':q'   => "%" . $q . "%"
]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
