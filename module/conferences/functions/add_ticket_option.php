<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$conference_id = (int)($_POST['conference_id'] ?? 0);
$option_name = trim($_POST['option_name'] ?? ($_POST['ticket_option']['name'] ?? ''));
$price = (float)($_POST['price'] ?? ($_POST['ticket_option']['price'] ?? 0));

if ($conference_id && $option_name !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_conference_ticket_options (user_id, conference_id, option_name, price) VALUES (?,?,?,?)');
  $stmt->execute([$this_user_id, $conference_id, $option_name, $price]);
  echo json_encode(['success'=>true,'id'=>$pdo->lastInsertId()]);
} else {
  echo json_encode(['success'=>false]);
}
