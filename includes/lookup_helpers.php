<?php
/**
 * Helper functions for lookup list items.
 */

/**
 * Fetch active lookup list items by list name or ID.
 *
 * @param PDO         $pdo  PDO connection.
 * @param int|string  $list Lookup list ID or name.
 * @return array              Array of items with id, label, code, color_class, icon_class and is_default.
 */
function get_lookup_items(PDO $pdo, int|string $list): array {
    $param = is_numeric($list) ? ':list_id' : ':list_name';
    $where = is_numeric($list) ? 'li.list_id = :list_id' : 'l.name = :list_name';

    $sql = "SELECT li.id, li.label, li.code, li.code AS value,
                   COALESCE(color_attr.attr_value, 'secondary') AS color_class,
                   COALESCE(icon_attr.attr_value, '') AS icon_class,
                   COALESCE(def_attr.attr_value = 'true', 0) AS is_default
            FROM lookup_list_items li
            JOIN lookup_lists l ON li.list_id = l.id
            LEFT JOIN lookup_list_item_attributes color_attr
                   ON li.id = color_attr.item_id AND color_attr.attr_code = 'COLOR-CLASS'
            LEFT JOIN lookup_list_item_attributes icon_attr
                   ON li.id = icon_attr.item_id AND icon_attr.attr_code = 'ICON-CLASS'
            LEFT JOIN lookup_list_item_attributes def_attr
                   ON li.id = def_attr.item_id AND def_attr.attr_code = 'DEFAULT'
            WHERE $where
              AND li.active_from <= CURDATE()
              AND (li.active_to IS NULL OR li.active_to >= CURDATE())
            ORDER BY li.sort_order, li.label";

    $stmt = $pdo->prepare($sql);
    $params = is_numeric($list) ? [':list_id' => $list] : [':list_name' => $list];
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Render a Phoenix badge for a lookup item.
 *
 * @param array             $lookupList Associative array of lookup items keyed by ID.
 * @param int|string|null   $id         Lookup item ID or null.
 * @param string|null       $classes    Optional additional classes (size etc.).
 * @param array             $attributes Optional attribute key/value pairs.
 * @return string                        HTML span markup for the badge.
 */
function render_status_badge(array $lookupList, int|string|null $id, ?string $classes = 'fs-10', array $attributes = []): string {
    if ($id === null) {
        return '';
    }

    $item  = $lookupList[$id] ?? ['color_class' => 'secondary', 'label' => 'Unknown'];
    $color = $item['color_class'] ?? 'secondary';
    $label = $item['label'] ?? 'Unknown';

    $attrString = '';
    foreach ($attributes as $attr => $value) {
        $attrString .= ' ' . htmlspecialchars($attr) . '="' . htmlspecialchars($value) . '"';
    }

    $classString = trim('badge badge-phoenix badge-phoenix-' . htmlspecialchars($color) . ' ' . ($classes ?? ''));

    return '<span class="' . $classString . '"' . $attrString . '><span class="badge-label">' . htmlspecialchars($label) . '</span></span>';
}

/**
 * Get a user's default lookup item for a specific list name.
 *
 * @param PDO    $pdo      PDO connection.
 * @param int    $userId   User ID.
 * @param string $listName Lookup list name.
 * @return int|null        Lookup item ID or null if none set.
 */
function get_user_default_lookup_item(PDO $pdo, int $userId, string $listName): ?int {
    $sql = 'SELECT item_id FROM module_users_defaults WHERE user_id = :uid AND list_name = :list';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':uid' => $userId, ':list' => $listName]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['item_id'] ?? null;
}

/**
 * Save or update a user's default lookup item for a list.
 *
 * @param PDO    $pdo         PDO connection.
 * @param int    $userId      User ID the default is for.
 * @param string $listName    Lookup list name.
 * @param int    $itemId      Lookup item ID.
 * @param int    $userUpdated User ID performing the update.
 */
function set_user_default_lookup_item(PDO $pdo, int $userId, string $listName, int $itemId, int $userUpdated): void {
    $sql = 'INSERT INTO module_users_defaults (user_id, user_updated, list_name, item_id)
            VALUES (:user_id, :user_updated, :list_name, :item_id)
            ON DUPLICATE KEY UPDATE item_id = VALUES(item_id), user_updated = VALUES(user_updated)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':user_id' => $userId,
        ':user_updated' => $userUpdated,
        ':list_name' => $listName,
        ':item_id' => $itemId,
    ]);
}


function get_lookup_item_label_from_id(PDO $pdo, int $itemId){
  $sql = 'SELECT label FROM `lookup_list_items` WHERE id = :item_id';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':item_id' => $itemId]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row['label'] ?? null;
}

?>
