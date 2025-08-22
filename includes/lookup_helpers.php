<?php
/**
 * Helper functions for lookup list items.
 */

/**
 * Fetch active lookup list items by list name or ID.
 *
 * @param PDO         $pdo  PDO connection.
 * @param int|string  $list Lookup list ID or name.
 * @return array              Array of items with id, label, code, color_class and is_default.
 */
function get_lookup_items(PDO $pdo, int|string $list): array {
    $param = is_numeric($list) ? ':list_id' : ':list_name';
    $where = is_numeric($list) ? 'li.list_id = :list_id' : 'l.name = :list_name';

    $sql = "SELECT li.id, li.label, li.code, li.code AS value,
                   COALESCE(color_attr.attr_value, 'secondary') AS color_class,
                   COALESCE(def_attr.attr_value = 'true', 0) AS is_default
            FROM lookup_list_items li
            JOIN lookup_lists l ON li.list_id = l.id
            LEFT JOIN lookup_list_item_attributes color_attr
                   ON li.id = color_attr.item_id AND color_attr.attr_code = 'COLOR-CLASS'
            LEFT JOIN lookup_list_item_attributes def_attr
                   ON li.id = def_attr.item_id AND def_attr.attr_code = 'DEFAULT'
            WHERE $where
              AND li.active_from <= CURDATE()
              AND (li.active_to IS NULL OR li.active_to >= CURDATE())
            ORDER BY li.id DESC, li.label";

    $stmt = $pdo->prepare($sql);
    $params = is_numeric($list) ? [':list_id' => $list] : [':list_name' => $list];
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Render a Phoenix badge for a lookup item.
 *
 * @param array       $lookupList Associative array of lookup items keyed by ID.
 * @param int|string  $id         Lookup item ID.
 * @param string|null $classes    Optional additional classes (size etc.).
 * @param array       $attributes Optional attribute key/value pairs.
 * @return string                  HTML span markup for the badge.
 */
function render_status_badge(array $lookupList, int|string $id, ?string $classes = 'fs-10', array $attributes = []): string {
    $item  = $lookupList[$id] ?? [];
    $color = $item['color_class'] ?? 'secondary';
    $label = $item['label'] ?? '';

    $attrString = '';
    foreach ($attributes as $attr => $value) {
        $attrString .= ' ' . htmlspecialchars($attr) . '="' . htmlspecialchars($value) . '"';
    }

    $classString = trim('badge badge-phoenix badge-phoenix-' . htmlspecialchars($color) . ' ' . ($classes ?? ''));

    return '<span class="' . $classString . '"' . $attrString . '><span class="badge-label">' . htmlspecialchars($label) . '</span></span>';
}

?>
