<?php
require '../../../includes/php_header.php';
require_permission('conference','delete');

$id = (int)($_GET['id'] ?? 0);
if ($id) {
  $stmt = $pdo->prepare('DELETE FROM module_conferences WHERE id=?');
  $stmt->execute([$id]);
}
header('Location: ../index.php');
exit;
