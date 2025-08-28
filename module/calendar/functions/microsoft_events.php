<?php

function fetch_microsoft_events(PDO $pdo, int $userId): array {
    $cacheKey = 'microsoft_calendar_events_' . $userId;
    if (isset($_SESSION[$cacheKey]) && $_SESSION[$cacheKey]['time'] > time() - 300) {
        return $_SESSION[$cacheKey]['data'];
    }

    $stmt = $pdo->prepare('SELECT access_token, refresh_token, token_expires FROM module_calendar_external_accounts WHERE user_id = ? AND provider = ?');
    $stmt->execute([$userId, 'microsoft']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return [];
    }
    $token = $row['access_token'] ?? '';
    $refreshToken = $row['refresh_token'] ?? '';
    $tokenExpires = $row['token_expires'] ?? '';

    if ($refreshToken && $tokenExpires && strtotime($tokenExpires) <= time()) {
        global $oauthConfig;
        $conf = $oauthConfig['microsoft'] ?? [];
        if (!empty($conf['client_id']) && !empty($conf['client_secret'])) {
            try {
                $ch = curl_init('https://login.microsoftonline.com/common/oauth2/v2.0/token');
                if ($ch === false) {
                    throw new Exception('Failed to initialize cURL');
                }
                $postFields = http_build_query([
                    'client_id' => $conf['client_id'],
                    'client_secret' => $conf['client_secret'],
                    'refresh_token' => $refreshToken,
                    'grant_type' => 'refresh_token'
                ]);
                curl_setopt_array($ch, [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postFields,
                    CURLOPT_RETURNTRANSFER => true,
                ]);
                $resp = curl_exec($ch);
                if ($resp === false) {
                    throw new Exception(curl_error($ch));
                }
                curl_close($ch);
            } catch (Exception $e) {
                if (isset($ch)) {
                    curl_close($ch);
                }
                error_log($e->getMessage());
                return [];
            }
            $tokenData = json_decode($resp, true);
            if (!empty($tokenData['access_token'])) {
                $token = $tokenData['access_token'];
                $refreshToken = $tokenData['refresh_token'] ?? $refreshToken;
                $expires = date('Y-m-d H:i:s', time() + (int)($tokenData['expires_in'] ?? 0));
                $upd = $pdo->prepare('UPDATE module_calendar_external_accounts SET access_token = ?, refresh_token = ?, token_expires = ? WHERE user_id = ? AND provider = ?');
                $upd->execute([$token, $refreshToken, $expires, $userId, 'microsoft']);
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    try {
        $ch = curl_init('https://graph.microsoft.com/v1.0/me/events?$select=id,subject,start,end&$orderby=start/dateTime&$top=50');
        if ($ch === false) {
            throw new Exception('Failed to initialize cURL');
        }
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token],
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $res = curl_exec($ch);
        if ($res === false) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
    } catch (Exception $e) {
        if (isset($ch)) {
            curl_close($ch);
        }
        error_log($e->getMessage());
        return [];
    }

    $data = json_decode($res, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
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
