<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');
ob_start();

require_once 'google_events.php';
require_once 'microsoft_events.php';

$calendar_id = isset($_GET['calendar_id']) ? (int)$_GET['calendar_id'] : 0;
$events = [];
if (user_has_role('Admin')) {
  if ($calendar_id) {
    $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, visibility_id FROM module_calendar_events WHERE calendar_id = :calid');
    $stmt->execute([':calid' => $calendar_id]);
  } else {
    $stmt = $pdo->query('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, visibility_id FROM module_calendar_events');
  }
} else {
  if ($calendar_id) {
    $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, visibility_id FROM module_calendar_events WHERE (visibility_id = 198 OR user_id = :uid) AND calendar_id = :calid');
    $stmt->execute([':uid' => $this_user_id, ':calid' => $calendar_id]);
  } else {
    $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, visibility_id FROM module_calendar_events WHERE visibility_id = 198 OR user_id = :uid');
    $stmt->execute([':uid' => $this_user_id]);
  }

try {
    if (user_has_role('Admin')) {
        if ($calendar_id) {
            $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, is_private FROM module_calendar_events WHERE calendar_id = :calid');
            $stmt->execute([':calid' => $calendar_id]);
        } else {
            $stmt = $pdo->query('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, is_private FROM module_calendar_events');
        }
    } else {
        if ($calendar_id) {
            $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, is_private FROM module_calendar_events WHERE (is_private = 0 OR user_id = :uid) AND calendar_id = :calid');
            $stmt->execute([':uid' => $this_user_id, ':calid' => $calendar_id]);
        } else {
            $stmt = $pdo->prepare('SELECT id, calendar_id, title, start_time, end_time, link_module, link_record_id, user_id, event_type_id, is_private FROM module_calendar_events WHERE is_private = 0 OR user_id = :uid');
            $stmt->execute([':uid' => $this_user_id]);
        }
    }

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $events[] = [
    'id' => (int)$row['id'],
    'calendar_id' => (int)$row['calendar_id'],
    'title' => $row['title'],
    'start' => $row['start_time'],
    'end' => $row['end_time'],
    'related_module' => $row['link_module'],
    'related_id' => $row['link_record_id'],
    'event_type_id' => $row['event_type_id'],
    'visibility_id' => (int)$row['visibility_id'],
    'is_private' => (int)($row['visibility_id'] == 199)
  ];
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

