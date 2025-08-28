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

/**
 * Fetch the default lookup list item ID for a given list name.
 *
 * A lookup item is considered the default when it has an attribute
 * `attr_code` of `DEFAULT` with an `attr_value` of `true`.
 *
 * @param PDO    $pdo   PDO connection
 * @param string $name  Lookup list name
 * @return int|null     ID of the default lookup item or null if none found
 */
function lookup_default_id(PDO $pdo, string $name): ?int {
    $sql = "SELECT li.id
            FROM lookup_list_items li
            JOIN lookup_lists l ON li.list_id = l.id
            JOIN lookup_list_item_attributes a
              ON a.item_id = li.id AND a.attr_code = 'DEFAULT'
            WHERE l.name = :name
              AND a.attr_value = 'true'
              AND li.active_from <= CURDATE()
              AND (li.active_to IS NULL OR li.active_to >= CURDATE())
            LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':name' => $name]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['id'] ?? null;
}

?>
