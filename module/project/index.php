<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'card';

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

$statusMap = array_column(get_lookup_items($pdo, 'PROJECT_STATUS'), null, 'id');
$stmt = $pdo->query('SELECT id, name, status FROM module_projects ORDER BY name');
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($projects as &$project) {
  $status = $statusMap[$project['status']] ?? null;
  $project['status_label'] = $status['label'] ?? null;
  $project['status_color'] = $status['color_class'] ?? 'secondary';
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
