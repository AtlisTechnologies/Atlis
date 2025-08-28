<?php

function refresh_token(string $provider, PDO $pdo, int $userId): string {
    try {
        $stmt = $pdo->prepare('SELECT access_token, refresh_token, token_expires FROM module_calendar_external_accounts WHERE user_id = ? AND provider = ?');
        $stmt->execute([$userId, $provider]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return '';
        }
        $token = $row['access_token'] ?? '';
        $refreshToken = $row['refresh_token'] ?? '';
        $tokenExpires = $row['token_expires'] ?? '';
        if ($refreshToken && $tokenExpires && strtotime($tokenExpires) <= time()) {
            global $oauthConfig;
            $conf = $oauthConfig[$provider] ?? [];
            $endpoints = [
                'google' => 'https://oauth2.googleapis.com/token',
                'microsoft' => 'https://login.microsoftonline.com/common/oauth2/v2.0/token'
            ];
            $endpoint = $endpoints[$provider] ?? '';
            if (!$endpoint || empty($conf['client_id']) || empty($conf['client_secret'])) {
                return '';
            }
            $ch = curl_init($endpoint);
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
            $tokenData = json_decode($resp, true);
            if (!empty($tokenData['access_token'])) {
                $token = $tokenData['access_token'];
                $refreshToken = $tokenData['refresh_token'] ?? $refreshToken;
                $expires = date('Y-m-d H:i:s', time() + (int)($tokenData['expires_in'] ?? 0));
                $upd = $pdo->prepare('UPDATE module_calendar_external_accounts SET access_token = ?, refresh_token = ?, token_expires = ? WHERE user_id = ? AND provider = ?');
                $upd->execute([$token, $refreshToken, $expires, $userId, $provider]);
            } else {
                return '';
            }
        }
        return $token;
    } catch (Exception $e) {
        if (isset($ch)) {
            curl_close($ch);
        }
        error_log($e->getMessage());
        return '';
    }
}

function fetch_remote_events(string $provider, string $token): array {
    $urls = [
        'google' => 'https://www.googleapis.com/calendar/v3/calendars/primary/events?maxResults=50&singleEvents=true&orderBy=startTime',
        'microsoft' => 'https://graph.microsoft.com/v1.0/me/events?$select=id,subject,start,end&$orderby=start/dateTime&$top=50'
    ];
    $url = $urls[$provider] ?? '';
    if (!$url) {
        return [];
    }
    try {
        $ch = curl_init($url);
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
        error_log(json_last_error_msg());
        return [];
    }
    return $data;
}

