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
  $typeMap   = get_lookup_items($pdo, 'PROJECT_TYPE');
  $agencies = $pdo->query('SELECT id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions = $pdo->query('SELECT id, name, agency_id FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $defaultAgencyId = get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_AGENCY');
  $defaultDivisionId = get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_DIVISION');
  require '../../includes/html_header.php';
  ?>
  <main class="main" id="top">
    <?php // require '../../includes/left_navigation.php'; ?>
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
               p.priority,
               lp.label AS priority_label,
               COALESCE(pattr.attr_value, 'secondary') AS priority_color,
               a.name AS agency_name,
               d.name AS division_name,
               COUNT(t.id) AS total_tasks,
               SUM(CASE WHEN t.completed = 1 THEN 1 ELSE 0 END) AS completed_tasks,
               SUM(CASE WHEN t.completed = 0 OR t.completed IS NULL THEN 1 ELSE 0 END) AS in_progress,
               pp.id AS pinned,
               ps.sort_order AS user_sort_order
        FROM module_projects p
        LEFT JOIN lookup_list_items li ON p.status = li.id
        LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = 'COLOR-CLASS'
        LEFT JOIN lookup_list_items lp ON p.priority = lp.id
        LEFT JOIN lookup_list_item_attributes pattr ON lp.id = pattr.item_id AND pattr.attr_code = 'COLOR-CLASS'
        LEFT JOIN module_agency a ON p.agency_id = a.id
        LEFT JOIN module_division d ON p.division_id = d.id
        LEFT JOIN module_projects_pins pp ON pp.project_id = p.id AND pp.user_id = :uid
        LEFT JOIN module_projects_sort ps ON ps.project_id = p.id AND ps.user_id = :uid
        LEFT JOIN module_tasks t ON t.project_id = p.id
        GROUP BY p.id
        ORDER BY (pp.id IS NOT NULL) DESC, CASE WHEN pp.id IS NOT NULL THEN pp.sort_order ELSE ps.sort_order END, p.name";

$stmt = $pdo->prepare($sql);
$stmt->execute([':uid' => $this_user_id]);

$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$assignStmt = $pdo->query("SELECT pa.project_id, pa.assigned_user_id, upp.file_path AS user_pic, CONCAT(per.first_name, ' ', per.last_name) AS name
                            FROM module_projects_assignments pa
                            LEFT JOIN users u ON pa.assigned_user_id = u.id
                            LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id
                            LEFT JOIN person per ON u.id = per.user_id");
$assignments = [];
foreach ($assignStmt as $row) {
  $row['file_path'] = $row['user_pic'];
  $assignments[$row['project_id']][] = $row;
}
foreach ($projects as &$project) {
  $project['assignees'] = $assignments[$project['id']] ?? [];
}
unset($project);

// Lookup lists passed to views for filtering options
$statusItems   = get_lookup_items($pdo, 'PROJECT_STATUS');
$priorityItems = get_lookup_items($pdo, 'PROJECT_PRIORITY');

  if ($action === 'details' || ($action === 'create-edit' && isset($_GET['id']))) {
    $project_id = (int)($_GET['id'] ?? 0);
    $params = [':id' => $project_id];
    $condition = 'p.id = :id';
    if (!user_has_role('Admin')) {
      $condition .= ' AND (p.is_private = 0 OR p.user_id = :uid)';
      $params[':uid'] = $this_user_id;
    }
    $stmt = $pdo->prepare('SELECT p.*, a.name AS agency_name, d.name AS division_name FROM module_projects p LEFT JOIN module_agency a ON p.agency_id = a.id LEFT JOIN module_division d ON p.division_id = d.id WHERE ' . $condition);
    $stmt->execute($params);
    $current_project = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$current_project) {
      http_response_code(404);
      exit;
    }

    $statusMap   = array_column(get_lookup_items($pdo,'PROJECT_STATUS'), null, 'id');
    $priorityMap = array_column(get_lookup_items($pdo,'PROJECT_PRIORITY'), null, 'id');
    $typeMap     = array_column(get_lookup_items($pdo,'PROJECT_TYPE'), null, 'id');
    if ($action === 'details') {
      $agencies  = $pdo->query('SELECT id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
      $divisions = $pdo->query('SELECT id, name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }
      $fileTypes   = get_lookup_items($pdo, 'PROJECT_FILE_TYPE');
      $fileStatuses = get_lookup_items($pdo, 'PROJECT_FILE_STATUS');
      $modalWidths = [
        'PDF' => 1000,
        'URL' => 1000
      ];

    if ($action === 'details' && $current_project) {
        $modalWidths     = [];
        $mwStmt = $pdo->prepare('SELECT li.code, COALESCE(attr.attr_value, "") AS width FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = "WIDTH" WHERE l.name = "PROJECT_FILE_MODAL_PREVIEW_WIDTH"');
        $mwStmt->execute();
        foreach ($mwStmt as $mw) {
          $modalWidths[$mw['code']] = $mw['width'];
        }

        $notesStmt = $pdo->prepare('SELECT n.id, n.user_id, n.note_text, n.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE n.project_id = :id ORDER BY n.date_created DESC');
      $notesStmt->execute([':id' => $project_id]);
      $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);
      $noteFilesStmt = $pdo->prepare('SELECT f.id, f.user_id, f.question_id, f.file_name, f.file_path, f.file_size, f.file_type, f.date_created, f.note_id, f.description, f.file_type_id, f.status_id, f.sort_order, CONCAT(p.first_name, " ", p.last_name) AS user_name, ft.code AS type_code, ft.label AS type_label, COALESCE(ft_color.attr_value, "secondary") AS type_color_class, COALESCE(ft_def.attr_value = "true", 0) AS type_is_default, fs.code AS status_code, fs.label AS status_label, COALESCE(fs_color.attr_value, "secondary") AS status_color_class, COALESCE(fs_def.attr_value = "true", 0) AS status_is_default FROM module_projects_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id LEFT JOIN lookup_list_items ft ON f.file_type_id = ft.id LEFT JOIN lookup_list_item_attributes ft_color ON ft.id = ft_color.item_id AND ft_color.attr_code = "COLOR-CLASS" LEFT JOIN lookup_list_item_attributes ft_def ON ft.id = ft_def.item_id AND ft_def.attr_code = "DEFAULT" LEFT JOIN lookup_list_items fs ON f.status_id = fs.id LEFT JOIN lookup_list_item_attributes fs_color ON fs.id = fs_color.item_id AND fs_color.attr_code = "COLOR-CLASS" LEFT JOIN lookup_list_item_attributes fs_def ON fs.id = fs_def.item_id AND fs_def.attr_code = "DEFAULT" WHERE f.project_id = :id AND f.note_id IS NOT NULL AND f.question_id IS NULL ORDER BY f.sort_order, f.date_created DESC');
      $noteFilesStmt->execute([':id' => $project_id]);
      $noteFilesRaw = $noteFilesStmt->fetchAll(PDO::FETCH_ASSOC);
      $noteFiles = [];
      foreach ($noteFilesRaw as $nf) {
        $noteFiles[$nf['note_id']][] = $nf;
      }


      $questionFilesStmt = $pdo->prepare('SELECT f.id, f.user_id, f.question_id, f.file_name, f.file_path, f.file_size, f.file_type, f.date_created, f.description, f.file_type_id, f.status_id, f.sort_order, CONCAT(p.first_name, " ", p.last_name) AS user_name, ft.code AS type_code, ft.label AS type_label, COALESCE(ft_color.attr_value, "secondary") AS type_color_class, COALESCE(ft_def.attr_value = "true", 0) AS type_is_default, fs.code AS status_code, fs.label AS status_label, COALESCE(fs_color.attr_value, "secondary") AS status_color_class, COALESCE(fs_def.attr_value = "true", 0) AS status_is_default FROM module_projects_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id LEFT JOIN lookup_list_items ft ON f.file_type_id = ft.id LEFT JOIN lookup_list_item_attributes ft_color ON ft.id = ft_color.item_id AND ft_color.attr_code = "COLOR-CLASS" LEFT JOIN lookup_list_item_attributes ft_def ON ft.id = ft_def.item_id AND ft_def.attr_code = "DEFAULT" LEFT JOIN lookup_list_items fs ON f.status_id = fs.id LEFT JOIN lookup_list_item_attributes fs_color ON fs.id = fs_color.item_id AND fs_color.attr_code = "COLOR-CLASS" LEFT JOIN lookup_list_item_attributes fs_def ON fs.id = fs_def.item_id AND fs_def.attr_code = "DEFAULT" WHERE f.project_id = :id AND f.question_id IS NOT NULL ORDER BY f.sort_order, f.date_created DESC');
      $questionFilesStmt->execute([':id' => $project_id]);
      $questionFilesRaw = $questionFilesStmt->fetchAll(PDO::FETCH_ASSOC);
      $questionFiles = [];
      foreach ($questionFilesRaw as $qf) {
        $questionFiles[$qf['question_id']][] = $qf;
      }

      $questionsStmt = $pdo->prepare('SELECT q.id, q.user_id, q.question_text, q.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_questions q LEFT JOIN users u ON q.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE q.project_id = :id ORDER BY q.date_created DESC');

      $questionsStmt->execute([':id' => $project_id]);
      $questions = $questionsStmt->fetchAll(PDO::FETCH_ASSOC);
      $questionAnswers = [];
      if ($questions) {
        $qIds = array_column($questions, 'id');
        $placeholders = implode(',', array_fill(0, count($qIds), '?'));
        $ansStmt = $pdo->prepare('SELECT a.id, a.question_id, a.user_id, a.answer_text, a.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_projects_answers a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE a.question_id IN (' . $placeholders . ') ORDER BY a.date_created ASC');
        $ansStmt->execute($qIds);
        foreach ($ansStmt as $arow) {
          $questionAnswers[$arow['question_id']][] = $arow;
        }
      }

        $taskSql =
          'SELECT t.id, t.name, t.status, t.priority, t.due_date, t.completed, ' .
          'li.label AS status_label, COALESCE(attr.attr_value, "secondary") AS status_color, ' .
          'lp.label AS priority_label, COALESCE(pattr.attr_value, "secondary") AS priority_color, ' .
          'CASE WHEN pa.id IS NULL THEN 0 ELSE 1 END AS project_assigned, ' .
          '(SELECT COUNT(*) FROM module_tasks_files tf WHERE tf.task_id = t.id) AS attachment_count ' .
          'FROM module_tasks t ' .
          'JOIN module_projects p ON t.project_id = p.id ' .
          'LEFT JOIN module_projects_assignments pa ON pa.project_id = p.id AND pa.assigned_user_id = :uid ' .
          'LEFT JOIN lookup_list_items li ON t.status = li.id ' .
          'LEFT JOIN lookup_list_item_attributes attr ON li.id = attr.item_id AND attr.attr_code = "COLOR-CLASS" ' .
          'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
          'LEFT JOIN lookup_list_item_attributes pattr ON lp.id = pattr.item_id AND pattr.attr_code = "COLOR-CLASS" ' .
          'WHERE t.project_id = :id';
        $taskParams = [':id' => $project_id, ':uid' => $this_user_id];
        if (!user_has_role('Admin')) {
          $taskSql .= ' AND (p.is_private = 0 OR p.user_id = :uid)';
        }
        $taskSql .= ' ORDER BY t.status, t.due_date';
        $tasksStmt = $pdo->prepare($taskSql);
        $tasksStmt->execute($taskParams);
      $tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);

      if ($tasks) {
        $taskIds = array_column($tasks, 'id');
        $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
          $taskAssignStmt = $pdo->prepare(
            'SELECT ta.task_id, ta.assigned_user_id, upp.file_path AS user_pic, CONCAT(per.first_name, " ", per.last_name) AS name '
            . 'FROM module_task_assignments ta '
            . 'LEFT JOIN users u ON ta.assigned_user_id = u.id '
            . 'LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id '
            . 'LEFT JOIN person per ON u.id = per.user_id '
            . 'WHERE ta.task_id IN (' . $placeholders . ')'
          );
        $taskAssignStmt->execute($taskIds);
        $taskAssignments = [];
        foreach ($taskAssignStmt as $row) {
            $taskAssignments[$row['task_id']][] = [
              'assigned_user_id' => $row['assigned_user_id'],
              'user_pic' => $row['user_pic'],
              'file_path' => $row['user_pic'],
              'name' => $row['name']
            ];
        }
        foreach ($tasks as &$tTask) {
          $tTask['assignees'] = $taskAssignments[$tTask['id']] ?? [];
        }
        unset($tTask);
      }

      $taskStatusItems   = get_lookup_items($pdo, 'TASK_STATUS');
      $taskPriorityItems = get_lookup_items($pdo, 'TASK_PRIORITY');

        $assignedStmt = $pdo->prepare('SELECT mpa.assigned_user_id AS user_id, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS name FROM module_projects_assignments mpa JOIN users u ON mpa.assigned_user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE mpa.project_id = :id');
      $assignedStmt->execute([':id' => $project_id]);
      $assignedUsers = [];
      foreach ($assignedStmt as $row) {
        $row['file_path'] = $row['user_pic'];
        $assignedUsers[] = $row;
      }

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
    $statusMap   = array_column(get_lookup_items($pdo,'PROJECT_STATUS'), null, 'id');
    $priorityMap = array_column(get_lookup_items($pdo,'PROJECT_PRIORITY'), null, 'id');
    $typeMap     = array_column(get_lookup_items($pdo,'PROJECT_TYPE'), null, 'id');
  }
}

// Ensure variables are defined for included views
$tasks = $tasks ?? [];
$assignedUsers = $assignedUsers ?? [];
$taskStatusItems = $taskStatusItems ?? [];
$taskPriorityItems = $taskPriorityItems ?? [];
  $modalWidths = $modalWidths ?? [];

$questions = $questions ?? [];
$questionAnswers = $questionAnswers ?? [];
$agencies = $agencies ?? [];
$divisions = $divisions ?? [];

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
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
