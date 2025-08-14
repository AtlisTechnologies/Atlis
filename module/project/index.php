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

      $notesStmt = $pdo->prepare('SELECT id,note_text,date_created FROM module_projects_notes WHERE project_id = :id ORDER BY date_created DESC');
      $notesStmt->execute([':id' => $project_id]);
      $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);
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
        'board' => 'board_view.php',
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
