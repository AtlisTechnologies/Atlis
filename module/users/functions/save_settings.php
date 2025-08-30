<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../includes/php_header.php';

if (!isset($this_user_id)) {
  exit;
}

$timezoneId = $_POST['timezone_id'] ?? null;
$stmt = $pdo->prepare('UPDATE users SET timezone_id = :tz, user_updated = :uid WHERE id = :uid');
$stmt->execute([
  ':tz' => $timezoneId === '' ? null : (int)$timezoneId,
  ':uid' => $this_user_id,
]);

$fields = [
  'project_status' => 'PROJECT_STATUS',
  'project_priority' => 'PROJECT_PRIORITY',
  'project_type' => 'PROJECT_TYPE',
  'project_agency' => 'PROJECT_AGENCY',
  'project_division' => 'PROJECT_DIVISION',
  'task_status' => 'TASK_STATUS',
  'task_priority' => 'TASK_PRIORITY',
  'calendar_default' => 'CALENDAR_DEFAULT',
  'calendar_event_type_default' => 'CALENDAR_EVENT_TYPE_DEFAULT',
];

foreach ($fields as $postField => $listName) {
  $value = $_POST[$postField] ?? '';
  if ($value === '') {
    $stmt = $pdo->prepare('DELETE FROM module_users_defaults WHERE user_id = :uid AND list_name = :list');
    $stmt->execute([':uid' => $this_user_id, ':list' => $listName]);
  } else {
    set_user_default_lookup_item($pdo, $this_user_id, $listName, (int)$value, $this_user_id);
  }
}

if (!empty($_POST['project_division']) && empty($_POST['project_agency'])) {
  $stmt = $pdo->prepare('SELECT agency_id FROM module_division WHERE id = :id');
  $stmt->execute([':id' => (int)$_POST['project_division']]);
  $agencyId = $stmt->fetchColumn();
  if ($agencyId) {
    set_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_AGENCY', (int)$agencyId, $this_user_id);
  }
}

header('Location: index.php?action=settings&saved=1');
exit;
?>
