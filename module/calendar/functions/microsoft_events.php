<?php

require_once __DIR__ . '/external_helper.php';

function fetch_microsoft_events(PDO $pdo, int $userId): array {
    $cacheKey = 'microsoft_calendar_events_' . $userId;
    if (isset($_SESSION[$cacheKey]) && $_SESSION[$cacheKey]['time'] > time() - 300) {
        return $_SESSION[$cacheKey]['data'];
    }

    $token = refresh_token('microsoft', $pdo, $userId);
    if (!$token) {
        return [];
    }

    $data = fetch_remote_events('microsoft', $token);
    if (!$data) {
        return [];
    }

    $events = [];
    if (!empty($data['value'])) {
        foreach ($data['value'] as $item) {
            $events[] = [
                'id' => 'microsoft-' . ($item['id'] ?? ''),
                'calendar_id' => 0,
                'title' => $item['subject'] ?? '',
                'start' => $item['start']['dateTime'] ?? '',
                'end' => $item['end']['dateTime'] ?? '',
                'related_module' => null,
                'related_id' => null,
                'event_type_id' => 0,
                'is_private' => 0,
                'source' => 'microsoft'
            ];
        }
    }

    $_SESSION[$cacheKey] = ['time' => time(), 'data' => $events];
    return $events;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    require '../../../includes/php_header.php';
    header('Content-Type: application/json');
    echo json_encode(fetch_microsoft_events($pdo, $this_user_id));
}
