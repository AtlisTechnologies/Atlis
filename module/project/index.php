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

$sql = "SELECT p.id, p.name, p.description, p.start_date, p.complete_date,
               li.label AS status_label,
               COALESCE(attr.attr_value, 'secondary') AS status_color,
               (SELECT COUNT(*) FROM module_tasks t WHERE t.project_id = p.id) AS total_tasks,
               (SELECT COUNT(*) FROM module_tasks t WHERE t.project_id = p.id AND t.completed = 0) AS in_progress
        FROM module_projects p
        LEFT JOIN lookup_list_items li ON p.status = li.id
        LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS'
        ORDER BY p.name";
$projects = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$assignStmt = $pdo->query("SELECT pa.project_id, u.profile_pic, CONCAT(per.first_name, ' ', per.last_name) AS name
                           FROM module_projects_assignments pa
                           LEFT JOIN users u ON pa.user_id = u.id
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
    $stmt = $pdo->prepare('SELECT * FROM module_projects WHERE id = :id');
    $stmt->execute([':id' => $project_id]);
    $current_project = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($action === 'details' && $current_project) {
      $filesStmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type,date_created FROM module_projects_files WHERE project_id = :id ORDER BY date_created DESC');
      $filesStmt->execute([':id' => $project_id]);
      $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

      $notesStmt = $pdo->prepare('SELECT n.id, n.note_text, n.date_created, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE n.project_id = :id ORDER BY n.date_created DESC');
      $notesStmt->execute([':id' => $project_id]);
      $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

      $tasksStmt = $pdo->prepare(
        'SELECT t.id, t.name, t.status, t.due_date, t.completed, li.label AS status_label, COALESCE(attr.attr_value, "secondary") AS status_color
         FROM module_tasks t
         LEFT JOIN lookup_list_items li ON t.status = li.id
         LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = "COLOR-CLASS"
         WHERE t.project_id = :id ORDER BY t.due_date'
      );
      $tasksStmt->execute([':id' => $project_id]);
      $tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);
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
