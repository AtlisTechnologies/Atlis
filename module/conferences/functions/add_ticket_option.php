<?php
require '../../../includes/php_header.php';
require_permission('conference','update');

$id = (int)($_POST['id'] ?? 0);
$option = trim($_POST['option'] ?? '');
if ($id && $option !== '') {
  $stmt = $pdo->prepare('SELECT ticket_options FROM module_conferences WHERE id=?');
  $stmt->execute([$id]);
  $opts = $stmt->fetchColumn();
  $optArr = $opts ? json_decode($opts, true) : [];
  $optArr[] = $option;
  $pdo->prepare('UPDATE module_conferences SET ticket_options=? WHERE id=?')->execute([json_encode($optArr),$id]);
}
echo json_encode(['success'=>true]);
