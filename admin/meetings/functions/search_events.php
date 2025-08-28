<?php
require '../../../includes/php_header.php';
require_permission('calendar', 'read');

header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if ($q === '') {
    echo json_encode([]);
    exit;
}

if (user_has_role('Admin')) {
    $stmt = $pdo->prepare('SELECT e.id, e.title, e.start_time FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE e.title LIKE :q ORDER BY e.start_time DESC LIMIT 10');
    $stmt->execute([':q' => "%" . $q . "%"]);
} else {
    $stmt = $pdo->prepare('SELECT e.id, e.title, e.start_time FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = :uid) AND (c.is_private = 0 OR c.user_id = :uid) AND e.title LIKE :q ORDER BY e.start_time DESC LIMIT 10');
    $stmt->execute([':uid' => $this_user_id, ':q' => "%" . $q . "%"]);
}

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
