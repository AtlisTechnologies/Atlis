<?php

function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token(?string $token): bool {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
}

function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function flash_message(string $message, string $type = 'success'): string {
    if ($message === '') {
        return '';
    }
    $type = e($type);
    $msg  = e($message);
    return '<div class="alert alert-' . $type . '">' . $msg . '</div>';
}

?>
