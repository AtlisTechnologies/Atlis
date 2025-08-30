<?php
if (!isset($pdo)) {
  require '../includes/php_header.php';
}
header('Content-Type: application/json');

if (!user_has_permission('calendar', 'read')) {
  audit_log($pdo, $this_user_id ?? 0, 'module_calendar_events', 0, 'READ', 'Unauthorized calendar list access');
  http_response_code(403);
  echo json_encode(['error' => 'Forbidden']);
  exit;
}

require_permission('calendar','read');
try {
  $scope = $_GET['scope'] ?? 'shared';

  $sql = 'SELECT id, title, start_time AS start, link_module, link_record_id FROM module_calendar_events';
  if ($scope === 'mine') {
    $sql .= ' WHERE user_id = :uid';
    $stmt = $pdo->prepare($sql);
    $uid = $this_user_id ?? 0;
    $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
  } else {
    $stmt = $pdo->prepare($sql);
  }
  $stmt->execute();
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (ob_get_length()) {
    ob_clean();
  }
  echo json_encode($events);
} catch (Exception $e) {
  http_response_code(500);
  if (ob_get_length()) {
    ob_clean();
  }
  error_log($e->getMessage());
  echo json_encode(['error' => 'Internal error']);
}
