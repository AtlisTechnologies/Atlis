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

function get_post(string $key, int $filter = FILTER_DEFAULT, array|int|null $options = null): mixed {
    return filter_input(INPUT_POST, $key, $filter, $options);
}

function get_get(string $key, int $filter = FILTER_DEFAULT, array|int|null $options = null): mixed {
    return filter_input(INPUT_GET, $key, $filter, $options);
}

function e(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function flash_message(string $message, string $type = 'success'): string {
    if ($message === '') {
        return '';
    }
    $type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');
    $msg  = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    return '<div class="alert alert-' . $type . '">' . $msg . '</div>';
}

?>
