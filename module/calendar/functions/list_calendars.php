<?php
require '../../../includes/php_header.php';

require_permission('calendar','read');

header('Content-Type: application/json');

try {
    $uid = $this_user_id;
    $stmt = $pdo->prepare(
        "SELECT c.id, c.name, c.user_id = :uid AS owned, c.is_private, " .
        "CASE WHEN c.user_id = :uid THEN c.ics_token ELSE NULL END AS ics_token, " .
        "COALESCE(CONCAT(p.first_name, ' ', p.last_name), u.email) AS owner " .
        "FROM module_calendar c " .
        "LEFT JOIN users u ON c.user_id = u.id " .
        "LEFT JOIN person p ON u.id = p.user_id " .
        "WHERE c.user_id = :uid OR c.is_private = 0 " .
        "ORDER BY owned DESC, c.name ASC"
    );
    $stmt->execute(['uid' => $uid]);
    $calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($calendars as &$cal) {
        if (!empty($cal['owned']) && empty($cal['ics_token'])) {
            $token = bin2hex(random_bytes(16));
            $upd = $pdo->prepare('UPDATE module_calendar SET ics_token = ? WHERE id = ?');
            $upd->execute([$token, $cal['id']]);
            $cal['ics_token'] = $token;
        }
    }
    echo json_encode($calendars);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

exit;
