<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$conference_id = (int)($_POST['conference_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$field_type = trim($_POST['field_type'] ?? '');
$field_options = trim($_POST['field_options'] ?? '');

if ($conference_id && $name !== '' && $field_type !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_conference_custom_fields (user_id, conference_id, name, field_type, field_options) VALUES (?,?,?,?,?)');
  $stmt->execute([$this_user_id, $conference_id, $name, $field_type, $field_options]);
  echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
} else {
  echo json_encode(['success'=>false]);
}
