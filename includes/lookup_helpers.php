<?php
/**
 * Helper functions for lookup list items.
 */

/**
 * Fetch active lookup list items by list name or ID.
 *
 * @param PDO         $pdo  PDO connection.
 * @param int|string  $list Lookup list ID or name.
 * @return array              Array of items with id, label, value and color_class.
 */
function get_lookup_items(PDO $pdo, int|string $list): array {
    $param = is_numeric($list) ? ':list_id' : ':list_name';
    $where = is_numeric($list) ? 'li.list_id = :list_id' : 'l.name = :list_name';

    $sql = "SELECT li.id, li.label, li.value,
                   COALESCE(attr.attr_value, 'secondary') AS color_class
            FROM lookup_list_items li
            JOIN lookup_lists l ON li.list_id = l.id
            LEFT JOIN lookup_list_item_attributes attr
                   ON li.id = attr.item_id AND attr.attr_key = 'COLOR-CLASS'
            WHERE $where
              AND li.active_from <= CURDATE()
              AND (li.active_to IS NULL OR li.active_to >= CURDATE())
            ORDER BY li.sort_order, li.label";

    $stmt = $pdo->prepare($sql);
    $params = is_numeric($list) ? [':list_id' => $list] : [':list_name' => $list];
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
