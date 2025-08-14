<?php
require '../../includes/php_header.php';
require_permission('task','read');

$action = $_GET['action'] ?? 'list';

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

if ($action === 'details' || ($action === 'create-edit' && isset($_GET['id']))) {
  $task_id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare('SELECT id, name, description, status, priority FROM module_tasks WHERE id = :id');
  $stmt->execute([':id' => $task_id]);
  $current_task = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($action === 'create-edit') {
  if (!empty($current_task)) {
    require_permission('task', 'update');
  } else {
    require_permission('task', 'create');
  }
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php
      $viewMap = [
        'card' => 'card_view.php',
        'list' => 'list_view.php',
        'board' => 'board_view.php',
        'details' => 'details_view.php',
        'create-edit' => 'create_edit_view.php'
      ];
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
