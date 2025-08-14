<?php
require '../../includes/php_header.php';
require_permission('task','read');

$statusMap = array_column(get_lookup_items($pdo, 'TASK_STATUS'), null, 'id');
$priorityMap = array_column(get_lookup_items($pdo, 'TASK_PRIORITY'), null, 'id');

$stmt = $pdo->query('SELECT id, name, status, priority FROM module_tasks ORDER BY name');
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($tasks as &$task) {
  $status = $statusMap[$task['status']] ?? null;
  $task['status_label'] = $status['label'] ?? null;
  $task['status_color'] = $status['color_class'] ?? 'secondary';
  $priority = $priorityMap[$task['priority']] ?? null;
  $task['priority_label'] = $priority['label'] ?? null;
}
unset($task);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php require 'include/list_view.php'; ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
