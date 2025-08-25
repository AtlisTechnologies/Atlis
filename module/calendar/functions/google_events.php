<?php
require '../../../includes/php_header.php';
require_permission('calendar','read');

function fetch_google_events(PDO $pdo, int $userId): array {
    $cacheKey = 'google_calendar_events';
    if (isset($_SESSION[$cacheKey]) && $_SESSION[$cacheKey]['time'] > time() - 300) {
        return $_SESSION[$cacheKey]['data'];
    }

    $stmt = $pdo->prepare('SELECT access_token FROM user_oauth_tokens WHERE user_id = ? AND provider = ?');
    $stmt->execute([$userId, 'google']);
    $token = $stmt->fetchColumn();
    if (!$token) {
        return [];
    }

    $ch = curl_init('https://www.googleapis.com/calendar/v3/calendars/primary/events?maxResults=50&singleEvents=true&orderBy=startTime');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token],
        CURLOPT_RETURNTRANSFER => true,
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($res, true);
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
                'visibility_id' => 0,
                'source' => 'google'
            ];
        }
    }

    $_SESSION[$cacheKey] = ['time' => time(), 'data' => $events];
    return $events;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    header('Content-Type: application/json');
    echo json_encode(fetch_google_events($pdo, $this_user_id));
}
