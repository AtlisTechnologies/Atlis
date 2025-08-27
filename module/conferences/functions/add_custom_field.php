<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$id = (int)($_POST['id'] ?? 0);
$field = trim($_POST['field'] ?? '');
$value = trim($_POST['value'] ?? '');
if ($id && $field !== '') {
  $stmt = $pdo->prepare('SELECT custom_fields FROM module_conferences WHERE id=?');
  $stmt->execute([$id]);
  $fields = $stmt->fetchColumn();
  $fieldArr = $fields ? json_decode($fields, true) : [];
  $fieldArr[$field] = $value;
  $pdo->prepare('UPDATE module_conferences SET custom_fields=? WHERE id=?')->execute([json_encode($fieldArr),$id]);
}
echo json_encode(['success'=>true]);
