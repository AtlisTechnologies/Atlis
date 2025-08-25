<?php
require '../../../includes/php_header.php';
require_permission('calendar','update');

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$start = $_POST['start'] ?? null;
$end = $_POST['end'] ?? null;
$related_module = $_POST['related_module'] ?? null;
$related_id = $_POST['related_id'] ?? null;
$event_type_id = $_POST['event_type_id'] ?? null;
$visibility_id = $_POST['visibility_id'] ?? null;
$attendees = $_POST['attendees'] ?? [];

if ($id && $title && $start) {
  $chk = $pdo->prepare('SELECT user_id, visibility_id FROM module_calendar_events WHERE id = ?');
  $chk->execute([$id]);
  $existing = $chk->fetch(PDO::FETCH_ASSOC);
  if (!$existing) {
    http_response_code(404);
    exit;
  }
  $privStmt = $pdo->prepare('SELECT id FROM lookup_list_items WHERE list_id=38 AND code="PRIVATE"');
  $privStmt->execute();
  $privateId = $privStmt->fetchColumn();
  if ($existing['visibility_id'] == $privateId && $existing['user_id'] != $this_user_id && !user_has_role('Admin')) {
    http_response_code(403);
    exit;
  }

  $stmt = $pdo->prepare('UPDATE module_calendar_events SET user_updated=?, title=?, start_date=?, end_date=?, event_type_id=?, visibility_id=?, related_module=?, related_id=? WHERE id=?');
  $stmt->execute([$this_user_id, $title, $start, $end, $event_type_id, $visibility_id, $related_module, $related_id, $id]);

  $pdo->prepare('DELETE FROM module_calendar_attendees WHERE calendar_event_id=?')->execute([$id]);
  if (is_array($attendees)) {
    $aStmt = $pdo->prepare('INSERT INTO module_calendar_attendees (user_id, calendar_event_id, attendee_user_id) VALUES (:uid, :eid, :aid)');
    foreach ($attendees as $aid) {
      $aStmt->execute([':uid' => $this_user_id, ':eid' => $id, ':aid' => $aid]);
    }
  }

  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);
