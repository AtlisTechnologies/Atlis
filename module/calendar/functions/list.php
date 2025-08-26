<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');
ob_start();

require_once 'google_events.php';
require_once 'microsoft_events.php';

$calendar_id = isset($_GET['calendar_id']) ? (int)$_GET['calendar_id'] : 0;
$events = [];

try {
    if (user_has_role('Admin')) {
        if ($calendar_id) {
            $stmt = $pdo->prepare('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE e.calendar_id = :calid');
            $stmt->execute([':calid' => $calendar_id]);
        } else {
            $stmt = $pdo->query('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id');
        }
    } else {
        if ($calendar_id) {
            $chk = $pdo->prepare('SELECT is_private, user_id FROM module_calendar WHERE id = :calid');
            $chk->execute([':calid' => $calendar_id]);
            $cal = $chk->fetch(PDO::FETCH_ASSOC);
            if ($cal && $cal['is_private'] && $cal['user_id'] != $this_user_id) {
                http_response_code(403);
                ob_clean();
                echo json_encode(['error' => 'Access denied']);
                exit;
            }
            $stmt = $pdo->prepare('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = :uid) AND (c.is_private = 0 OR c.user_id = :uid) AND e.calendar_id = :calid');
            $stmt->execute([':uid' => $this_user_id, ':calid' => $calendar_id]);
        } else {
            $stmt = $pdo->prepare('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = :uid) AND (c.is_private = 0 OR c.user_id = :uid)');
            $stmt->execute([':uid' => $this_user_id]);
        }
    }

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        $visibility = $row['visibility_id'] === null ? 198 : (int)$row['visibility_id'];

        $events[] = [
            'id' => (int)$row['id'],
            'calendar_id' => (int)$row['calendar_id'],
            'title' => $row['title'],
            'start' => $row['start_time'],
            'end' => $row['end_time'],
            'related_module' => $row['link_module'],
            'related_id' => $row['link_record_id'],
            'event_type_id' => $row['event_type_id'],
            'visibility_id' => $visibility,
            'is_private' => (int)$row['is_private']
        ];
    }
} catch (Exception $e) {
    http_response_code(500);
    ob_clean();
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

try {
    $extEvents = [];
    $stmt = $pdo->prepare('SELECT provider FROM module_calendar_external_accounts WHERE user_id = ?');
    $stmt->execute([$this_user_id]);
    $providers = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    http_response_code(500);
    ob_clean();
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

if (!empty($providers)) {
    if (in_array('google', $providers, true)) {
        try {
            $extEvents = array_merge($extEvents, fetch_google_events($pdo, $this_user_id));
        } catch (Exception $e) {
            http_response_code(500);
            ob_clean();
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    if (in_array('microsoft', $providers, true)) {
        try {
            $extEvents = array_merge($extEvents, fetch_microsoft_events($pdo, $this_user_id));
        } catch (Exception $e) {
            http_response_code(500);
            ob_clean();
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }
    $events = array_merge($events, $extEvents);
}

ob_clean();
echo json_encode($events);

