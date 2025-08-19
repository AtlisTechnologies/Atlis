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
    <?php // require '../../includes/left_navigation.php'; ?>
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

if ($action === 'create-edit' && isset($_GET['modal'])) {
  $isModal = true;
  $id = (int)($_GET['id'] ?? 0);
  if ($id) {
    require_permission('task', 'update');
    $stmt = $pdo->prepare('SELECT * FROM module_tasks WHERE id=?');
    $stmt->execute([$id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $assignedUsers = $pdo->prepare('SELECT assigned_user_id FROM module_task_assignments WHERE task_id=?');
    $assignedUsers->execute([$id]);
    $assignedUsers = $assignedUsers->fetchAll(PDO::FETCH_COLUMN);
  } else {
    require_permission('task', 'create');
    $task = [];
    $assignedUsers = [];
  }
  $statusMap = get_lookup_items($pdo, 'TASK_STATUS');
  $priorityMap = get_lookup_items($pdo, 'TASK_PRIORITY');
  $projects = $pdo->query('SELECT id,name FROM module_projects ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $agencies = $pdo->query('SELECT id,name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions = $pdo->query('SELECT id,name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $users = $pdo->query('SELECT id,email FROM users ORDER BY email')->fetchAll(PDO::FETCH_ASSOC);

  require 'include/form.php';
  exit;
}

require_permission('task','read');

$action = $_GET['action'] ?? 'list';

$taskStatusItems   = get_lookup_items($pdo, 'TASK_STATUS');
$taskPriorityItems = get_lookup_items($pdo, 'TASK_PRIORITY');

$stmt = $pdo->query(
  'SELECT t.id, t.name, t.status, t.priority, t.due_date, t.completed, ' .
  'ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color, ' .
  'lp.label AS priority_label, COALESCE(lpat.attr_value, "secondary") AS priority_color, ' .
  '(SELECT COUNT(*) FROM module_tasks_files tf WHERE tf.task_id = t.id) AS attachment_count ' .
  'FROM module_tasks t ' .
  'LEFT JOIN lookup_list_items ls ON t.status = ls.id ' .
  'LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS" ' .
  'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
  'LEFT JOIN lookup_list_item_attributes lpat ON lp.id = lpat.item_id AND lpat.attr_code = "COLOR-CLASS" ' .
  'ORDER BY t.status, t.due_date'
);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($tasks) {
  $taskIds = array_column($tasks, 'id');
  $placeholders = implode(',', array_fill(0, count($taskIds), '?'));
    $taskAssignStmt = $pdo->prepare(
      'SELECT ta.task_id, ta.assigned_user_id, upp.file_path, CONCAT(per.first_name, " ", per.last_name) AS name '
      . 'FROM module_task_assignments ta '
      . 'LEFT JOIN users u ON ta.assigned_user_id = u.id '
      . 'LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id AND upp.is_active = 1 '
      . 'LEFT JOIN person per ON u.id = per.user_id '
      . 'WHERE ta.task_id IN (' . $placeholders . ')'
    );
  $taskAssignStmt->execute($taskIds);
  $taskAssignments = [];
  foreach ($taskAssignStmt as $row) {
      $taskAssignments[$row['task_id']][] = [
        'assigned_user_id' => $row['assigned_user_id'],
        'file_path'      => $row['file_path'],
        'name'             => $row['name']
      ];
  }
  foreach ($tasks as &$tTask) {
    $tTask['assignees'] = $taskAssignments[$tTask['id']] ?? [];
  }
  unset($tTask);
}

if ($action === 'details') {
  $task_id = (int)($_GET['id'] ?? 0);

  $stmt = $pdo->prepare(
    'SELECT t.id, t.name, t.description, t.status, t.priority,
            t.project_id, t.division_id, t.agency_id, t.completed, t.completed_by,
            p.name AS project_name,
            d.name AS division_name,
            a.name AS agency_name,
            o.name AS organization_name,
            CONCAT(cbp.first_name, " ", cbp.last_name) AS completed_by_name
     FROM module_tasks t
     LEFT JOIN module_projects p ON t.project_id = p.id
     LEFT JOIN module_division d ON t.division_id = d.id
     LEFT JOIN module_agency a ON t.agency_id = a.id
     LEFT JOIN module_organization o ON a.organization_id = o.id
     LEFT JOIN users cb ON t.completed_by = cb.id
     LEFT JOIN person cbp ON cb.id = cbp.user_id
     WHERE t.id = :id'
  );

  $stmt->execute([':id' => $task_id]);
  $current_task = $stmt->fetch(PDO::FETCH_ASSOC);

  $availableUsers = [];
  if ($current_task) {

      $assignedStmt = $pdo->prepare('SELECT mta.assigned_user_id AS user_id, upp.file_path, CONCAT(p.first_name, " ", p.last_name) AS name FROM module_task_assignments mta JOIN users u ON mta.assigned_user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id AND upp.is_active = 1 LEFT JOIN person p ON u.id = p.user_id WHERE mta.task_id = :id');
    $assignedStmt->execute([':id' => $task_id]);
    $assignedUsers = $assignedStmt->fetchAll(PDO::FETCH_ASSOC);

    $assignedIds = array_column($assignedUsers, 'user_id');
    if (!empty($current_task['project_id'])) {
      $params = [$current_task['project_id']];
      $query = "SELECT u.id AS user_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM module_projects_assignments mpa JOIN users u ON mpa.assigned_user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE mpa.project_id = ?";
      if ($assignedIds) {
        $placeholders = implode(',', array_fill(0, count($assignedIds), '?'));
        $query .= " AND u.id NOT IN ($placeholders)";
        $params = array_merge($params, $assignedIds);
      }
      $query .= ' ORDER BY name';
      $availableStmt = $pdo->prepare($query);
      $availableStmt->execute($params);
    } else {
      if ($assignedIds) {
        $placeholders = implode(',', array_fill(0, count($assignedIds), '?'));
        $availableStmt = $pdo->prepare("SELECT u.id AS user_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id NOT IN ($placeholders) ORDER BY name");
        $availableStmt->execute($assignedIds);
      } else {
        $availableStmt = $pdo->query("SELECT u.id AS user_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id ORDER BY name");
      }
    }
    if (isset($availableStmt)) {
      $availableUsers = $availableStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $filesStmt = $pdo->prepare('SELECT f.id,f.user_id,f.note_id,f.file_name,f.file_path,f.file_size,f.file_type,f.date_created, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_tasks_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE f.task_id = :id ORDER BY f.date_created DESC');
    $filesStmt->execute([':id' => $task_id]);
    $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

    $notesStmt = $pdo->prepare('SELECT n.id,n.user_id,n.note_text,n.date_created, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_tasks_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE n.task_id = :id ORDER BY n.date_created DESC');

    $notesStmt->execute([':id' => $task_id]);
    $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

    $taskFiles = [];
    $noteFiles = [];
    foreach ($files as $f) {
      if (!empty($f['note_id'])) {
        $noteFiles[$f['note_id']][] = $f;
      } else {
        $taskFiles[] = $f;
      }
    }
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
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
