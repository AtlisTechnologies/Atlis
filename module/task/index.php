<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;
  $name = $_POST['name'] ?? '';
  $status = $_POST['status'] ?? null;
  $priority = $_POST['priority'] ?? null;
  $project_id = $_POST['project_id'] ?? null;
  $agency_id = $_POST['agency_id'] ?? null;
  $division_id = $_POST['division_id'] ?? null;
  $assigned_users = $_POST['assigned_users'] ?? [];

  if ($id) {
    require_permission('task','update');
    $stmt = $pdo->prepare('UPDATE module_tasks SET user_updated=?, name=?, status=?, priority=?, project_id=?, agency_id=?, division_id=? WHERE id=?');
    $stmt->execute([$this_user_id, $name, $status, $priority, $project_id, $agency_id, $division_id, $id]);
    $taskId = $id;
    $pdo->prepare('DELETE FROM module_task_assignments WHERE task_id=?')->execute([$taskId]);
  } else {
    require_permission('task','create');
    $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, name, status, priority, project_id, agency_id, division_id) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$this_user_id, $name, $status, $priority, $project_id, $agency_id, $division_id]);
    $taskId = $pdo->lastInsertId();
  }
  $assignStmt = $pdo->prepare('INSERT INTO module_task_assignments (user_id, task_id, assigned_user_id) VALUES (?,?,?)');
  foreach ($assigned_users as $uid) {
    $assignStmt->execute([$this_user_id, $taskId, $uid]);
  }
  header('Location: index.php');
  exit;
}

if ($action === 'create' || $action === 'edit') {
  if ($action === 'edit') {
    require_permission('task','update');
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT * FROM module_tasks WHERE id=?');
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $assignedUsers = $pdo->prepare('SELECT assigned_user_id FROM module_task_assignments WHERE task_id=?');
    $assignedUsers->execute([$id]);
    $assignedUsers = $assignedUsers->fetchAll(PDO::FETCH_COLUMN);
  } else {
    require_permission('task','create');
    $task = [];
    $assignedUsers = [];
  }
  $statusMap = get_lookup_items($pdo, 'TASK_STATUS');
  $priorityMap = get_lookup_items($pdo, 'TASK_PRIORITY');
  $projects = $pdo->query('SELECT id,name FROM module_projects ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $agencies = $pdo->query('SELECT id,name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions = $pdo->query('SELECT id,name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $users = $pdo->query('SELECT id,email FROM users ORDER BY email')->fetchAll(PDO::FETCH_ASSOC);

  require '../../includes/html_header.php';
  ?>
  <main class="main" id="top">
    <?php require '../../includes/left_navigation.php'; ?>
    <?php require '../../includes/navigation.php'; ?>
    <div id="main_content" class="content">
      <?php require 'include/form.php'; ?>
      <?php require '../../includes/html_footer.php'; ?>
    </div>
  </main>
  <?php require '../../includes/js_footer.php'; ?>
  <?php
  exit;
}

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
  $task['priority_color'] = $priority['color_class'] ?? 'secondary';
}
unset($task);

if ($action === 'details') {
  $task_id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare(
    'SELECT t.id, t.name, t.description, t.status, t.priority,
            p.name AS project_name,
            d.name AS division_name,
            a.name AS agency_name,
            o.name AS organization_name
     FROM module_tasks t
     LEFT JOIN module_projects p ON t.project_id = p.id
     LEFT JOIN module_division d ON t.division_id = d.id
     LEFT JOIN module_agency a ON t.agency_id = a.id
     LEFT JOIN module_organization o ON a.organization_id = o.id
     WHERE t.id = :id'
  );
  $stmt->execute([':id' => $task_id]);
  $current_task = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($current_task) {
    $project_name = $current_task['project_name'] ?? null;
    $division_name = $current_task['division_name'] ?? null;
    $agency_name = $current_task['agency_name'] ?? null;
    $organization_name = $current_task['organization_name'] ?? null;
    $assignStmt = $pdo->prepare('SELECT u.id, u.email FROM module_task_assignments ta JOIN users u ON ta.assigned_user_id = u.id WHERE ta.task_id = :id');
    $assignStmt->execute([':id' => $task_id]);
    $assignments = $assignStmt->fetchAll(PDO::FETCH_ASSOC);

    $filesStmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type,date_created FROM module_tasks_files WHERE task_id = :id ORDER BY date_created DESC');
    $filesStmt->execute([':id' => $task_id]);
    $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

    $notesStmt = $pdo->prepare('SELECT id,note_text,date_created FROM module_tasks_notes WHERE task_id = :id ORDER BY date_created DESC');
    $notesStmt->execute([':id' => $task_id]);
    $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $project_name = $division_name = $agency_name = $organization_name = null;
  }
} elseif ($action === 'create-edit' && isset($_GET['id'])) {
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
