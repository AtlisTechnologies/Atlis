<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $meeting_date = $_POST['meeting_date'] ?? null;
  $stmt = $pdo->prepare('UPDATE module_meetings SET user_updated=?, title=?, meeting_date=? WHERE id=?');
  $stmt->execute([$this_user_id, $title, $meeting_date, $id]);
  audit_log($pdo, $this_user_id, 'module_meeting', $id, 'UPDATE', 'Updated meeting');
  header('Location: ../index.php?action=details&id=' . $id);
  exit;
}

http_response_code(405);
