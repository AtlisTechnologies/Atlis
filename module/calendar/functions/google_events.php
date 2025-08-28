<?php

require_once __DIR__ . '/external_helper.php';

function fetch_google_events(PDO $pdo, int $userId): array {
    $cacheKey = 'google_calendar_events_' . $userId;
    if (isset($_SESSION[$cacheKey]) && $_SESSION[$cacheKey]['time'] > time() - 300) {
        return $_SESSION[$cacheKey]['data'];
    }

    $token = refresh_token('google', $pdo, $userId);
    if (!$token) {
        return [];
    }

    $data = fetch_remote_events('google', $token);
    if (!$data) {
        return [];
    }

    $events = [];
    if (!empty($data['items'])) {
        foreach ($data['items'] as $item) {
            $events[] = [
                'id' => 'google-' . ($item['id'] ?? ''),
                'calendar_id' => 0,
                'title' => $item['summary'] ?? '',
                'start' => $item['start']['dateTime'] ?? $item['start']['date'] ?? '',
                'end' => $item['end']['dateTime'] ?? $item['end']['date'] ?? '',
                'related_module' => null,
                'related_id' => null,
                'event_type_id' => 0,
                'is_private' => 0,
                'source' => 'google'
            ];
        }
    }

    $_SESSION[$cacheKey] = ['time' => time(), 'data' => $events];
    return $events;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    require '../../../includes/php_header.php';
    header('Content-Type: application/json');
    echo json_encode(fetch_google_events($pdo, $this_user_id));
}
