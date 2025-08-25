<?php
require '../../../includes/php_header.php';
require_permission('calendar','read');

function fetch_microsoft_events(PDO $pdo, int $userId): array {
    $cacheKey = 'microsoft_calendar_events';
    if (isset($_SESSION[$cacheKey]) && $_SESSION[$cacheKey]['time'] > time() - 300) {
        return $_SESSION[$cacheKey]['data'];
    }

    $stmt = $pdo->prepare('SELECT access_token FROM user_oauth_tokens WHERE user_id = ? AND provider = ?');
    $stmt->execute([$userId, 'microsoft']);
    $token = $stmt->fetchColumn();
    if (!$token) {
        return [];
    }

    $ch = curl_init('https://graph.microsoft.com/v1.0/me/events?$select=id,subject,start,end&$orderby=start/dateTime&$top=50');
    curl_setopt_array($ch, [
        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token],
        CURLOPT_RETURNTRANSFER => true,
    ]);
    $res = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($res, true);
    $events = [];
    if (!empty($data['value'])) {
        foreach ($data['value'] as $item) {
            $events[] = [
                'id' => 'ms-' . ($item['id'] ?? ''),
                'calendar_id' => 0,
                'title' => $item['subject'] ?? '',
                'start' => $item['start']['dateTime'] ?? '',
                'end' => $item['end']['dateTime'] ?? '',
                'related_module' => null,
                'related_id' => null,
                'event_type_id' => 0,
                'visibility_id' => 0,
                'source' => 'microsoft'
            ];
        }
    }

    $_SESSION[$cacheKey] = ['time' => time(), 'data' => $events];
    return $events;
}

if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])) {
    header('Content-Type: application/json');
    echo json_encode(fetch_microsoft_events($pdo, $this_user_id));
}
