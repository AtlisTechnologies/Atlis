<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? null;
  $assigned_users = $_POST['assigned_users'] ?? [];

  if ($id) {
    require_permission('task','update');
    $existingStmt = $pdo->prepare('SELECT t.name, t.status, t.priority, t.project_id, t.agency_id, t.division_id, t.user_id AS task_owner, t.is_private, p.user_id AS project_owner, p.is_private AS project_private FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id=?');
    $existingStmt->execute([$id]);
    $existing = $existingStmt->fetch(PDO::FETCH_ASSOC) ?: [];
    if (!$existing || (
        ($existing['project_id'] && $existing['project_private'] && !user_has_role('Admin') && $existing['project_owner'] != $this_user_id) ||
        (!$existing['project_id'] && $existing['is_private'] && !user_has_role('Admin') && $existing['task_owner'] != $this_user_id)
      )) {
      http_response_code(403);
      exit;
    }

    $name = array_key_exists('name', $_POST) ? $_POST['name'] : ($existing['name'] ?? null);
    $status = array_key_exists('status', $_POST) ? $_POST['status'] : ($existing['status'] ?? null);
    $priority = array_key_exists('priority', $_POST) ? $_POST['priority'] : ($existing['priority'] ?? null);
    $project_id = array_key_exists('project_id', $_POST) ? $_POST['project_id'] : ($existing['project_id'] ?? null);
    $agency_id = array_key_exists('agency_id', $_POST) ? $_POST['agency_id'] : ($existing['agency_id'] ?? null);
    $division_id = array_key_exists('division_id', $_POST) ? $_POST['division_id'] : ($existing['division_id'] ?? null);
    $is_private = $project_id ? 0 : (!empty($_POST['is_private']) ? 1 : 0);

    $stmt = $pdo->prepare('UPDATE module_tasks SET user_updated=?, name=?, status=?, priority=?, project_id=?, agency_id=?, division_id=?, is_private=? WHERE id=?');
    $stmt->execute([$this_user_id, $name, $status, $priority, $project_id, $agency_id, $division_id, $is_private, $id]);
    $taskId = $id;
    $pdo->prepare('DELETE FROM module_task_assignments WHERE task_id=?')->execute([$taskId]);
  } else {
    require_permission('task','create');
    $name = $_POST['name'] ?? '';
    $status = $_POST['status'] ?? null;
    $priority = $_POST['priority'] ?? null;
    $project_id = $_POST['project_id'] ?? null;
    $agency_id = $_POST['agency_id'] ?? null;
    $division_id = $_POST['division_id'] ?? null;
    $is_private = $project_id ? 0 : (!empty($_POST['is_private']) ? 1 : 0);
    if ($project_id) {
      $pchk = $pdo->prepare('SELECT user_id, is_private FROM module_projects WHERE id = ?');
      $pchk->execute([$project_id]);
      $proj = $pchk->fetch(PDO::FETCH_ASSOC);
      if ($proj && $proj['is_private'] && !user_has_role('Admin') && $proj['user_id'] != $this_user_id) {
        http_response_code(403);
        exit;
      }
    }
    $stmt = $pdo->prepare('INSERT INTO module_tasks (user_id, name, status, priority, project_id, agency_id, division_id, is_private) VALUES (?,?,?,?,?,?,?,?)');
    $stmt->execute([$this_user_id, $name, $status, $priority, $project_id, $agency_id, $division_id, $is_private]);
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
    $query = 'SELECT t.* FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id=?';
    $params = [$id];
    if (!user_has_role('Admin')) {
      $query .= ' AND (p.id IS NULL OR p.is_private = 0 OR p.user_id = ?) AND (t.project_id IS NOT NULL OR t.is_private = 0 OR t.user_id = ?)';
      $params[] = $this_user_id;
      $params[] = $this_user_id;
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $task = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    if (!$task) {
      http_response_code(404);
      exit;
    }
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
  $defaultTaskStatusId = get_user_default_lookup_item($pdo, $this_user_id, 'TASK_STATUS');
  if ($defaultTaskStatusId === null) {
    foreach ($statusMap as $s) {
      if (!empty($s['is_default'])) { $defaultTaskStatusId = $s['id']; break; }
    }
  }
  $defaultTaskPriorityId = get_user_default_lookup_item($pdo, $this_user_id, 'TASK_PRIORITY');
  if ($defaultTaskPriorityId === null) {
    foreach ($priorityMap as $p) {
      if (!empty($p['is_default'])) { $defaultTaskPriorityId = $p['id']; break; }
    }
  }
  if (user_has_role('Admin')) {
    $projects = $pdo->query('SELECT id,name FROM module_projects ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $pstmt = $pdo->prepare('SELECT id,name FROM module_projects WHERE is_private = 0 OR user_id = :uid ORDER BY name');
    $pstmt->execute([':uid' => $this_user_id]);
    $projects = $pstmt->fetchAll(PDO::FETCH_ASSOC);
  }
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
    $taskSql =
      'SELECT t.id, t.user_id, t.user_updated, t.date_created, t.date_updated, t.memo, t.project_id, t.agency_id, t.division_id, ' .
      't.name, t.description, t.requirements, t.specifications, t.status, t.previous_status, t.priority, t.start_date, t.due_date, ' .
      't.complete_date, t.completed, t.completed_by, t.progress_percent FROM module_tasks t ' .
      'LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id = :id';
    $taskParams = [':id' => $id];
    if (!user_has_role('Admin')) {
    $taskSql .= ' AND (p.id IS NULL OR p.is_private = 0 OR p.user_id = :uid) AND (t.project_id IS NOT NULL OR t.is_private = 0 OR t.user_id = :uid)';
      $taskParams[':uid'] = $this_user_id;
    }
    $stmt = $pdo->prepare($taskSql);
    $stmt->execute($taskParams);
    $task = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    if (!$task) {
      http_response_code(404);
      exit;
    }
    $assignedStmt = $pdo->prepare('SELECT assigned_user_id FROM module_task_assignments WHERE task_id = :id');
    $assignedStmt->execute([':id' => $id]);
    $assignedUsers = $assignedStmt->fetchAll(PDO::FETCH_COLUMN);
  } else {
    require_permission('task', 'create');
    $task = [];
    $assignedUsers = [];
  }
  $statusMap   = get_lookup_items($pdo, 'TASK_STATUS');
  $priorityMap = get_lookup_items($pdo, 'TASK_PRIORITY');
  $defaultTaskStatusId = get_user_default_lookup_item($pdo, $this_user_id, 'TASK_STATUS');
  if ($defaultTaskStatusId === null) {
    foreach ($statusMap as $s) {
      if (!empty($s['is_default'])) { $defaultTaskStatusId = $s['id']; break; }
    }
  }
  $defaultTaskPriorityId = get_user_default_lookup_item($pdo, $this_user_id, 'TASK_PRIORITY');
  if ($defaultTaskPriorityId === null) {
    foreach ($priorityMap as $p) {
      if (!empty($p['is_default'])) { $defaultTaskPriorityId = $p['id']; break; }
    }
  }
  if (user_has_role('Admin')) {
    $projects = $pdo->query('SELECT id,name FROM module_projects ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $pstmt = $pdo->prepare('SELECT id,name FROM module_projects WHERE is_private = 0 OR user_id = :uid ORDER BY name');
    $pstmt->execute([':uid' => $this_user_id]);
    $projects = $pstmt->fetchAll(PDO::FETCH_ASSOC);
  }
  $agencies    = $pdo->query('SELECT id,name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions   = $pdo->query('SELECT id,name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $users       = $pdo->query('SELECT id,email FROM users ORDER BY email')->fetchAll(PDO::FETCH_ASSOC);

  require 'include/form.php';
  exit;
}

require_permission('task','read');

$action = $_GET['action'] ?? 'list';

$taskStatusItems   = get_lookup_items($pdo, 'TASK_STATUS');
$taskPriorityItems = get_lookup_items($pdo, 'TASK_PRIORITY');

$taskSql =
  'SELECT t.id, t.name, t.status, t.previous_status, t.priority, t.due_date, t.completed, ' .
  'ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color, ' .
  'lp.label AS priority_label, COALESCE(lpat.attr_value, "secondary") AS priority_color, ' .
  'CASE WHEN pa.id IS NULL THEN 0 ELSE 1 END AS project_assigned, ' .
  '(SELECT COUNT(*) FROM module_tasks_files tf WHERE tf.task_id = t.id) AS attachment_count ' .
  'FROM module_tasks t ' .
  'LEFT JOIN module_projects p ON t.project_id = p.id ' .
  'LEFT JOIN module_projects_assignments pa ON pa.project_id = t.project_id AND pa.assigned_user_id = :uid ' .
  'LEFT JOIN lookup_list_items ls ON t.status = ls.id ' .
  'LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS" ' .
  'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
  'LEFT JOIN lookup_list_item_attributes lpat ON lp.id = lpat.item_id AND lpat.attr_code = "COLOR-CLASS"';
$taskParams = [':uid' => $this_user_id];
if (!user_has_role('Admin')) {
  $taskSql .= ' WHERE (p.id IS NULL OR p.is_private = 0 OR p.user_id = :uid) AND (t.project_id IS NOT NULL OR t.is_private = 0 OR t.user_id = :uid)';
}
$taskSql .= ' ORDER BY t.status DESC, t.priority, t.due_date, t.name';
$stmt = $pdo->prepare($taskSql);
$stmt->execute($taskParams);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        'user_pic'         => $row['user_pic'],
        'file_path'        => $row['user_pic'],
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

  $statusMap   = array_column(get_lookup_items($pdo, 'TASK_STATUS'), null, 'id');
  $priorityMap = array_column(get_lookup_items($pdo, 'TASK_PRIORITY'), null, 'id');

  $taskSql =
    'SELECT t.id, t.name, t.description, t.status, t.priority,' .
            ' t.start_date, t.due_date, t.progress_percent, t.requirements, t.specifications,' .
            ' t.project_id, t.division_id, t.agency_id, t.completed, t.completed_by,' .
            ' p.name AS project_name,' .
            ' d.name AS division_name,' .
            ' a.name AS agency_name,' .
            ' o.name AS organization_name,' .
            ' CONCAT(cbp.first_name, " ", cbp.last_name) AS completed_by_name' .
     ' FROM module_tasks t' .
     ' LEFT JOIN module_projects p ON t.project_id = p.id' .
     ' LEFT JOIN module_division d ON t.division_id = d.id' .
     ' LEFT JOIN module_agency a ON t.agency_id = a.id' .
     ' LEFT JOIN module_organization o ON a.organization_id = o.id' .
     ' LEFT JOIN users cb ON t.completed_by = cb.id' .
     ' LEFT JOIN person cbp ON cb.id = cbp.user_id' .
     ' WHERE t.id = :id';
  $taskParams = [':id' => $task_id];
  if (!user_has_role('Admin')) {
    $taskSql .= ' AND (p.id IS NULL OR p.is_private = 0 OR p.user_id = :uid) AND (t.project_id IS NOT NULL OR t.is_private = 0 OR t.user_id = :uid)';
    $taskParams[':uid'] = $this_user_id;
  }
  $stmt = $pdo->prepare($taskSql);
  $stmt->execute($taskParams);
  $current_task = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$current_task) {
    http_response_code(404);
    exit;
  }

  $availableUsers = [];
  $questions = [];
  $questionAnswers = [];
  if ($current_task) {

      $assignedStmt = $pdo->prepare('SELECT mta.assigned_user_id AS user_id, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS name FROM module_task_assignments mta JOIN users u ON mta.assigned_user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE mta.task_id = :id');
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

    $filesStmt = $pdo->prepare('SELECT f.id,f.user_id,f.note_id,f.question_id,f.file_name,f.file_path,f.file_size,f.file_type,f.date_created, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_tasks_files f LEFT JOIN users u ON f.user_id = u.id LEFT JOIN person p ON u.id = p.user_id WHERE f.task_id = :id ORDER BY f.date_created DESC');
    $filesStmt->execute([':id' => $task_id]);
    $files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

    $notesStmt = $pdo->prepare('SELECT n.id,n.user_id,n.note_text,n.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_tasks_notes n LEFT JOIN users u ON n.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE n.task_id = :id ORDER BY n.date_created DESC');

    $notesStmt->execute([':id' => $task_id]);
    $notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

    $questionsStmt = $pdo->prepare('SELECT q.id,q.user_id,q.question_text,q.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, " ", p.last_name) AS user_name FROM module_tasks_questions q LEFT JOIN users u ON q.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE q.task_id = :id ORDER BY q.date_created DESC');
    $questionsStmt->execute([':id' => $task_id]);
    $questions = $questionsStmt->fetchAll(PDO::FETCH_ASSOC);

    if ($questions) {
      $qids = array_column($questions, 'id');
      $placeholders = implode(',', array_fill(0, count($qids), '?'));
      $answersStmt = $pdo->prepare("SELECT a.id,a.question_id,a.user_id,a.answer_text,a.date_created, upp.file_path AS user_pic, CONCAT(p.first_name, ' ', p.last_name) AS user_name FROM module_tasks_answers a LEFT JOIN users u ON a.user_id = u.id LEFT JOIN users_profile_pics upp ON u.current_profile_pic_id = upp.id LEFT JOIN person p ON u.id = p.user_id WHERE a.question_id IN ($placeholders) ORDER BY a.date_created ASC");
      $answersStmt->execute($qids);
      while ($row = $answersStmt->fetch(PDO::FETCH_ASSOC)) {
        $questionAnswers[$row['question_id']][] = $row;
      }
    }

    $taskFiles = [];
    $noteFiles = [];
    $questionFiles = [];
    foreach ($files as $f) {
      if (!empty($f['question_id'])) {
        $questionFiles[$f['question_id']][] = $f;
      } elseif (!empty($f['note_id'])) {
        $noteFiles[$f['note_id']][] = $f;
      } else {
        $taskFiles[] = $f;
      }
    }
  }
} elseif ($action === 'create-edit' && isset($_GET['id'])) {
  $task_id = (int)($_GET['id'] ?? 0);
  $query = 'SELECT t.id, t.name, t.description, t.status, t.priority FROM module_tasks t LEFT JOIN module_projects p ON t.project_id = p.id WHERE t.id = :id';
  $params = [':id' => $task_id];
  if (!user_has_role('Admin')) {
    $query .= ' AND (p.id IS NULL OR p.is_private = 0 OR p.user_id = :uid) AND (t.project_id IS NOT NULL OR t.is_private = 0 OR t.user_id = :uid)';
    $params[':uid'] = $this_user_id;
  }
  $stmt = $pdo->prepare($query);
  $stmt->execute($params);
  $current_task = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$current_task) {
    http_response_code(404);
    exit;
  }
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
