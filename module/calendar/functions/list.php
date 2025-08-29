<?php
require '../../../includes/php_header.php';
require_permission('calendar', 'read');
header('Content-Type: application/json');

require_once 'google_events.php';
require_once 'microsoft_events.php';

$events = [];

$raw_ids = $_GET['calendar_ids'] ?? [];
if (is_string($raw_ids)) {
    $raw_ids = $raw_ids !== '' ? explode(',', $raw_ids) : [];
} elseif (!is_array($raw_ids)) {
    $raw_ids = [];
}
$calendar_ids = array_filter(array_unique(array_map('intval', $raw_ids)));

$start = isset($_GET['start']) && is_string($_GET['start']) ? $_GET['start'] : null;
$end = isset($_GET['end']) && is_string($_GET['end']) ? $_GET['end'] : null;
$q = isset($_GET['q']) && is_string($_GET['q']) ? trim($_GET['q']) : null;
$eventTypeId = isset($_GET['event_type_id']) && is_numeric($_GET['event_type_id']) ? (int)$_GET['event_type_id'] : null;
$filterTime = $start !== null && $end !== null;

try {
    if (empty($calendar_ids)) {
        $stmt = $pdo->prepare('SELECT id FROM module_calendar WHERE user_id = ? AND is_private = 0 LIMIT 1');
        $stmt->execute([$this_user_id]);
        $defaultCalendarId = $stmt->fetchColumn();
        $calendar_ids = $defaultCalendarId ? [(int)$defaultCalendarId] : [];
    }
    $isAdmin = user_has_role('Admin');

    if (!$isAdmin && !empty($calendar_ids)) {
        $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
        $chkSql = "SELECT id FROM module_calendar WHERE id IN ($placeholders) AND is_private = 1 AND user_id <> ?";
        $chkParams = array_merge($calendar_ids, [$this_user_id]);
        $chk = $pdo->prepare($chkSql);
        $chk->execute($chkParams);
        if ($chk->fetch(PDO::FETCH_ASSOC)) {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }
    }

    $sql = "SELECT e.id, e.calendar_id, e.title, e.memo, e.start_time, e.end_time, e.location, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.user_id AS calendar_user_id, COALESCE(color_attr.attr_value, 'secondary') AS color_class, COALESCE(icon_attr.attr_value, '') AS icon_class FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id LEFT JOIN lookup_list_item_attributes color_attr ON e.event_type_id = color_attr.item_id AND color_attr.attr_code = 'COLOR-CLASS' LEFT JOIN lookup_list_item_attributes icon_attr ON e.event_type_id = icon_attr.item_id AND icon_attr.attr_code = 'ICON-CLASS'";
    $where = [];
    $params = [];

    if (!$isAdmin) {
        $where[] = '(e.visibility_id = 198 OR e.user_id = ?)';
        $where[] = '(c.is_private = 0 OR c.user_id = ?)';
        $params[] = $this_user_id;
        $params[] = $this_user_id;
    }

    if (!empty($calendar_ids)) {
        $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
        $where[] = "e.calendar_id IN ($placeholders)";
        $params = array_merge($params, $calendar_ids);
    }

    if ($filterTime) {
        $where[] = 'e.start_time < ? AND e.end_time > ?';
        $params[] = $end;
        $params[] = $start;
    }

    if ($q !== null && $q !== '') {
        $where[] = '(e.title LIKE ? OR e.memo LIKE ?)';
        $like = '%' . $q . '%';
        $params[] = $like;
        $params[] = $like;
    }

    if ($eventTypeId !== null) {
        $where[] = 'e.event_type_id = ?';
        $params[] = $eventTypeId;
    }

    if ($where) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    $dbEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($filterTime && empty($dbEvents)) {
        echo json_encode([]);
        return;
    }

    foreach ($dbEvents as $row) {

        $visibility = $row['visibility_id'] === null ? 198 : (int)$row['visibility_id'];

        $events[] = [
            'id' => (int)$row['id'],
            'calendar_id' => (int)$row['calendar_id'],
            'title' => $row['title'],
            'description' => $row['memo'],
            'start' => $row['start_time'],
            'end' => $row['end_time'],
            'location' => $row['location'],
            'related_module' => $row['link_module'],
            'related_id' => $row['link_record_id'],
            'event_type_id' => $row['event_type_id'] !== null ? (int)$row['event_type_id'] : null,
            'color_class' => $row['color_class'],
            'icon_class' => $row['icon_class'],
            'visibility_id' => $visibility,
            'user_id' => (int)$row['user_id'],
            'calendar_user_id' => (int)$row['calendar_user_id'],
            'is_private' => $visibility === 199 ? 1 : 0
        ];
    }
    $extEvents = [];
    $stmt = $pdo->prepare('SELECT provider FROM module_calendar_external_accounts WHERE user_id = ?');
    $stmt->execute([$this_user_id]);
    $providers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($providers) && function_exists('curl_init')) {
        if (in_array('google', $providers, true)) {
            $extEvents = array_merge($extEvents, fetch_google_events($pdo, $this_user_id));
        }
        if (in_array('microsoft', $providers, true)) {
            $extEvents = array_merge($extEvents, fetch_microsoft_events($pdo, $this_user_id));
        }
        $events = array_merge($events, $extEvents);
    }

    echo json_encode($events);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
    return;
}

