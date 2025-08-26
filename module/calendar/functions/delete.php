<?php
require '../../../includes/php_header.php';

require_permission('calendar','delete');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
if ($id) {
  $chk = $pdo->prepare('SELECT user_id, visibility_id FROM module_calendar_events WHERE id = ?');
  $chk->execute([$id]);
  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }
  if ($existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }
  if ($existing['visibility_id'] == 199 && $existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    // Only the event owner or an Admin can delete a private event.
    http_response_code(403);
    exit;
  }
  $pdo->prepare('DELETE FROM module_calendar_event_attendees WHERE event_id=?')->execute([$id]);
  $pdo->prepare('DELETE FROM module_calendar_events WHERE id=?')->execute([$id]);
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);
