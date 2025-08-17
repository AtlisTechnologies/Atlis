<?php
require '../../../includes/php_header.php';
require_permission('task','update');
header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$field = $_POST['field'] ?? '';
$value = (int)($_POST['value'] ?? 0);

if ($id > 0 && in_array($field, ['status','priority'], true)) {
  $stmt = $pdo->prepare("UPDATE module_tasks SET {$field} = :value, user_updated = :uid WHERE id = :id");
  $stmt->execute([
    ':value' => $value,
    ':uid' => $this_user_id,
    ':id' => $id
  ]);

  $lookupStmt = $pdo->prepare("SELECT li.label, COALESCE(attr.attr_value, :default_color) AS color_class FROM lookup_list_items li LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS' WHERE li.id = :id LIMIT 1");
  $lookupStmt->execute([':id' => $value, ':default_color' => $field === 'priority' ? 'primary' : 'secondary']);
  $row = $lookupStmt->fetch(PDO::FETCH_ASSOC) ?: [];
  audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Updated task ' . $field);
  echo json_encode([
    'success' => true,
    'label' => $row['label'] ?? '',
    'color' => $row['color_class'] ?? ($field === 'priority' ? 'primary' : 'secondary')
  ]);
  exit;
}

echo json_encode(['success' => false]);
