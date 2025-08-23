<?php
if (!isset($pdo)) {
  require '../../../includes/php_header.php';
}
require_permission('feedback', 'list');

$stmt = $pdo->query('SELECT id, title, type, date_created FROM module_feedback ORDER BY date_created DESC');
$feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
