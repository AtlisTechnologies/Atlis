<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require 'functions/create.php';
  exit;
}

if ($action === 'create') {
  require_permission('project', 'create');
  $statusMap = get_lookup_items($pdo, 'PROJECT_STATUS');
  $agencies = $pdo->query('SELECT id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions = $pdo->query('SELECT id, name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  require '../../includes/html_header.php';
  ?>
  <main class="main" id="top">
    <?php require '../../includes/left_navigation.php'; ?>
    <?php require '../../includes/navigation.php'; ?>
    <div id="main_content" class="content">
      <?php require 'include/create_edit.php'; ?>
      <?php require '../../includes/html_footer.php'; ?>
    </div>
  </main>
  <?php require '../../includes/js_footer.php'; ?>
  <?php
  exit;
}

require_permission('project','read');

$sql = "SELECT p.id,
               p.name,
               p.description,
               p.start_date,
               p.complete_date,
               li.label AS status_label,
               COALESCE(attr.attr_value, 'secondary') AS status_color,
               a.name AS agency_name,
               d.name AS division_name,
               COUNT(t.id) AS total_tasks,
               SUM(CASE WHEN t.completed = 0 OR t.completed IS NULL THEN 1 ELSE 0 END) AS in_progress,
               SUM(CASE WHEN t.completed = 1 THEN 1 ELSE 0 END) AS completed_tasks
        FROM module_projects p
        LEFT JOIN lookup_list_items li ON p.status = li.id
        LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS'
        LEFT JOIN module_agency a ON p.agency_id = a.id
        LEFT JOIN module_division d ON p.division_id = d.id
        LEFT JOIN module_tasks t ON t.project_id = p.id
        GROUP BY p.id
        ORDER BY p.name";
$projects = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$assignStmt = $pdo->query("SELECT pa.project_id, pa.assigned_user_id, u.profile_pic, CONCAT(per.first_name, ' ', per.last_name) AS name
                           FROM module_projects_assignments pa
                           LEFT JOIN users u ON pa.assigned_user_id = u.id
                           LEFT JOIN person per ON u.id = per.user_id");
$assignments = [];
foreach ($assignStmt as $row) {
  $assignments[$row['project_id']][] = $row;
}
foreach ($projects as &$project) {
  $project['assignees'] = $assignments[$project['id']] ?? [];
}
unset($project);

  if ($action === 'details' || ($action === 'create-edit' && isset($_GET['id']))) {
    $project_id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT p.*, a.name AS agency_name, d.name AS division_name FROM module_projects p LEFT JOIN module_agency a ON p.agency_id = a.id LEFT JOIN module_division d ON p.division_id = d.id WHERE p.id = :id');
    $stmt->execute([':id' => $project_id]);
    $current_project = $stmt->fetch(PDO::FETCH_ASSOC);

    $statusMap   = array_column(get_lookup_items($pdo,'PROJECT_STATUS'), null, 'id');
    $priorityMap = array_column(get_lookup_items($pdo,'PROJECT_PRIORITY'), null, 'id');

    if ($action === 'details' && $current_project) {

      $filesStmt = $pdo->prepare('SELECT f.id, f.user_id, f.file_name, f.file_path, f.file_size, f.file_type, f.date_created, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE f.project_id = :id AND f.note_id IS NULL ORDER BY f.date_created DESC');

      $filesStmt->execute([':id' => $project_id]);
      $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

      $notesStmt = $pdo->prepare('SELECT n.id, n.user_id, n.note_text, n.date_created, u.profile_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE n.project_id = :id ORDER BY n.date_created DESC');
      $notesStmt->execute([':id' => $project_id]);
      $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

      $noteFilesStmt = $pdo->prepare('SELECT f.id, f.user_id, f.file_name, f.file_path, f.file_size, f.file_type, f.date_created, f.note_id, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE f.project_id = :id AND f.note_id IS NOT NULL ORDER BY f.date_created DESC');
      $noteFilesStmt->execute([':id' => $project_id]);
      $noteFilesRaw = $noteFilesStmt->fetchAll(PDO::FETCH_ASSOC);
      $noteFiles = [];
      foreach ($noteFilesRaw as $nf) {
        $noteFiles[$nf['note_id']][] = $nf;
      }

        $tasksStmt = $pdo->prepare(
          'SELECT t.id, t.name, t.status, t.due_date, t.completed, li.label AS status_label, COALESCE(attr.attr_value, "secondary") AS status_color, ' .
          '(SELECT COUNT(*) FROM module_tasks_files tf WHERE tf.task_id = t.id) AS attachment_count ' .
          'FROM module_tasks t ' .
          'LEFT JOIN lookup_list_items li ON t.status = li.id ' .
          'LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = "COLOR-CLASS" ' .
          'WHERE t.project_id = :id ORDER BY t.status, t.due_date'
        );
      $tasksStmt->execute([':id' => $project_id]);
      $tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);

      if ($tasks) {
        $taskIds = array_column($tasks, 'id');
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
        $taskAssignStmt = $pdo->prepare(
          'SELECT ta.task_id, ta.assigned_user_id, u.profile_pic, CONCAT(per.first_name, " ", per.last_name) AS name '
          . 'FROM module_task_assignments ta '
          . 'LEFT JOIN users u ON ta.assigned_user_id = u.id '
          . 'LEFT JOIN person per ON u.id = per.user_id '
          . 'WHERE ta.task_id IN (' . $placeholders . ')'
        );
        $taskAssignStmt->execute($taskIds);
        $taskAssignments = [];
        foreach ($taskAssignStmt as $row) {
          $taskAssignments[$row['task_id']][] = [
            'assigned_user_id' => $row['assigned_user_id'],
            'profile_pic' => $row['profile_pic'],
            'name' => $row['name']
          ];
        }
        foreach ($tasks as &$tTask) {
          $tTask['assignees'] = $taskAssignments[$tTask['id']] ?? [];
        }
        unset($tTask);
      }

      $assignedStmt = $pdo->prepare('SELECT mpa.assigned_user_id AS user_id, u.profile_pic, CONCAT(p.first_name, " ", p.last_name) AS name FROM module_projects_assignments mpa JOIN users u ON mpa.assigned_user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE mpa.project_id = :id');
      $assignedStmt->execute([':id' => $project_id]);
      $assignedUsers = $assignedStmt->fetchAll(PDO::FETCH_ASSOC);

      $assignedIds = array_column($assignedUsers, 'user_id');
      if ($assignedIds) {
        $placeholders = implode(',', array_fill(0, count($assignedIds), '?'));
        $availableStmt = $pdo->prepare("SELECT u.id AS user_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id NOT IN ($placeholders) ORDER BY name");
        $availableStmt->execute($assignedIds);
      } else {
        $availableStmt = $pdo->query("SELECT u.id AS user_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id ORDER BY name");
      }
      $availableUsers = $availableStmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }

if ($action === 'create-edit') {
  if (!empty($current_project)) {
    require_permission('project', 'update');
  } else {
    require_permission('project', 'create');
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
      $viewFile = $viewMap[$action] ?? 'card_view.php';
      require 'include/' . $viewFile;
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
