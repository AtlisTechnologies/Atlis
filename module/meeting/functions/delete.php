<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'delete');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $stmt = $pdo->prepare('DELETE FROM module_meetings WHERE id=?');
  $stmt->execute([$id]);
  audit_log($pdo, $this_user_id, 'module_meeting', $id, 'DELETE', 'Deleted meeting');
  header('Content-Type: application/json');
  echo json_encode(['success'=>true]);
  exit;
}

http_response_code(405);
