<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('feedback', 'details');

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT id, title, description, type, date_created FROM module_feedback WHERE id = :id');
$stmt->execute([':id' => $id]);
$feedbackItem = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
