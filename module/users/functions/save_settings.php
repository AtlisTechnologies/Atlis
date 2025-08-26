<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
require_once '../../includes/php_header.php';

if (!isset($this_user_id)) {
  exit;
}

$fields = [
  'project_status' => 'PROJECT_STATUS',
  'project_priority' => 'PROJECT_PRIORITY',
  'project_type' => 'PROJECT_TYPE',
  'task_status' => 'TASK_STATUS',
  'task_priority' => 'TASK_PRIORITY',
  'calendar_default' => 'CALENDAR_DEFAULT',
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

header('Location: index.php?action=settings&saved=1');
exit;
?>
