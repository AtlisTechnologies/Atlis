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

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;
$filterTime = $start !== null && $end !== null;

try {
    if (user_has_role('Admin')) {
        if (!empty($calendar_ids)) {
            $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
            $sql = "SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE e.calendar_id IN ($placeholders)";
            if ($filterTime) {
                $sql .= ' AND e.start_time < :end AND e.end_time > :start';
            }
            $stmt = $pdo->prepare($sql);
            $index = 1;
            foreach ($calendar_ids as $id) {
                $stmt->bindValue($index++, $id, PDO::PARAM_INT);
            }
            if ($filterTime) {
                $stmt->bindValue(':start', $start, PDO::PARAM_STR);
                $stmt->bindValue(':end', $end, PDO::PARAM_STR);
            }
            $stmt->execute();
        } else {
            $sql = 'SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id';
            if ($filterTime) {
                $sql .= ' WHERE e.start_time < :end AND e.end_time > :start';
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':start', $start, PDO::PARAM_STR);
                $stmt->bindValue(':end', $end, PDO::PARAM_STR);
                $stmt->execute();
            } else {
                $stmt = $pdo->query($sql);
            }
        }
    } else {
        if (!empty($calendar_ids)) {
            $placeholders = implode(',', array_fill(0, count($calendar_ids), '?'));
            $chk = $pdo->prepare("SELECT id FROM module_calendar WHERE id IN ($placeholders) AND is_private = 1 AND user_id <> ?");
            $chkIndex = 1;
            foreach ($calendar_ids as $id) {
                $chk->bindValue($chkIndex++, $id, PDO::PARAM_INT);
            }
            $chk->bindValue($chkIndex, $this_user_id, PDO::PARAM_INT);
            $chk->execute();
            if ($chk->fetch(PDO::FETCH_ASSOC)) {
                http_response_code(403);
                ob_clean();
                echo json_encode(['error' => 'Access denied']);
                exit;
            }
            $sql = "SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = ?) AND (c.is_private = 0 OR c.user_id = ?) AND e.calendar_id IN ($placeholders)";
            if ($filterTime) {
                $sql .= ' AND e.start_time < :end AND e.end_time > :start';
            }
            $stmt = $pdo->prepare($sql);
            $idx = 1;
            $stmt->bindValue($idx++, $this_user_id, PDO::PARAM_INT);
            $stmt->bindValue($idx++, $this_user_id, PDO::PARAM_INT);
            foreach ($calendar_ids as $id) {
                $stmt->bindValue($idx++, $id, PDO::PARAM_INT);
            }
            if ($filterTime) {
                $stmt->bindValue(':start', $start, PDO::PARAM_STR);
                $stmt->bindValue(':end', $end, PDO::PARAM_STR);
            }
            $stmt->execute();
        } else {
            $sql = 'SELECT e.id, e.calendar_id, e.title, e.start_time, e.end_time, e.link_module, e.link_record_id, e.user_id, e.event_type_id, e.visibility_id, c.is_private, c.user_id AS calendar_user_id FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id = c.id WHERE (e.visibility_id = 198 OR e.user_id = ?) AND (c.is_private = 0 OR c.user_id = ?)';
            if ($filterTime) {
                $sql .= ' AND e.start_time < :end AND e.end_time > :start';
            }
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $this_user_id, PDO::PARAM_INT);
            $stmt->bindValue(2, $this_user_id, PDO::PARAM_INT);
            if ($filterTime) {
                $stmt->bindValue(':start', $start, PDO::PARAM_STR);
                $stmt->bindValue(':end', $end, PDO::PARAM_STR);
            }
            $stmt->execute();
        }
    }

    $dbEvents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($filterTime && empty($dbEvents)) {
        ob_clean();
        echo json_encode([]);
        exit;
    }

    foreach ($dbEvents as $row) {

        $visibility = $row['visibility_id'] === null ? 198 : (int)$row['visibility_id'];

        $events[] = [
            'id' => (int)$row['id'],
            'calendar_id' => (int)$row['calendar_id'],
            'title' => $row['title'],
            'start' => $row['start_time'],
            'end' => $row['end_time'],
            'related_module' => $row['link_module'],
            'related_id' => $row['link_record_id'],
            'event_type_id' => $row['event_type_id'] !== null ? (int)$row['event_type_id'] : null,
            'visibility_id' => $visibility,
            'user_id' => (int)$row['user_id'],
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

