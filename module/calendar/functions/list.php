<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');
ob_start();

require_once 'google_events.php';
require_once 'microsoft_events.php';

$events = [];

$raw_ids = $_GET['calendar_ids'] ?? [];
if (!is_array($raw_ids)) {
    $raw_ids = explode(',', $raw_ids);
}
$calendar_ids = array_unique(array_map('intval', $raw_ids));
if (empty($calendar_ids) || in_array(0, $calendar_ids, true)) {
    try {
        $stmt = $pdo->prepare('SELECT id FROM module_calendar WHERE user_id = ? AND is_private = 0 LIMIT 1');
        $stmt->execute([$this_user_id]);
        $defaultCalendarId = $stmt->fetchColumn();
        $calendar_ids = $defaultCalendarId ? [(int)$defaultCalendarId] : [];
    } catch (Exception $e) {
        $calendar_ids = [];
    }
}
$calendar_ids = array_filter($calendar_ids);

try {
    if (user_has_role('Admin')) {
        if (!empty($calendar_ids)) {
            $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
            $sql = "SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE e.calendar_id IN ($placeholders)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($calendar_ids);
        } else {
            $stmt = $pdo->query('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id');
        }
    } else {
        if (!empty($calendar_ids)) {
            $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
            $chk = $pdo->prepare("SELECT id FROM module_calendar WHERE id IN ($placeholders) AND is_private = 1 AND user_id <> ?");
            $chk->execute(array_merge($calendar_ids, [$this_user_id]));
            if ($chk->fetch(PDO::FETCH_ASSOC)) {
                http_response_code(403);
                ob_clean();
                echo json_encode(['error' => 'Access denied']);
                exit;
            }
            $sql = "SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = ?) AND (c.is_private = 0 OR c.user_id = ?) AND e.calendar_id IN ($placeholders)";
            $params = array_merge([$this_user_id, $this_user_id], $calendar_ids);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
        } else {
            $stmt = $pdo->prepare('SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = ?) AND (c.is_private = 0 OR c.user_id = ?)');
            $stmt->execute([$this_user_id, $this_user_id]);
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
            'calendar_user_id' => (int)$row['calendar_user_id'],
            'is_private' => (int)$row['is_private']
        ];
    }
} catch (Exception $e) {
    http_response_code(500);
    ob_clean();
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$extEvents = [];
$providers = [];
try {
    $stmt = $pdo->prepare('SELECT provider FROM module_calendar_external_accounts WHERE user_id = ?');
    $stmt->execute([$this_user_id]);
    $providers = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (Exception $e) {
    $providers = [];
}

if (!empty($providers) && function_exists('curl_init')) {
    if (in_array('google', $providers, true)) {
        try {
            $extEvents = array_merge($extEvents, fetch_google_events($pdo, $this_user_id));
        } catch (Exception $e) {
            $providers = [];
        }
    }
    if (!empty($providers) && in_array('microsoft', $providers, true)) {
        try {
            $extEvents = array_merge($extEvents, fetch_microsoft_events($pdo, $this_user_id));
        } catch (Exception $e) {
            $providers = [];
        }
    }
    $events = array_merge($events, $extEvents);
}

ob_clean();
echo json_encode($events);

