<?php
require '../../../includes/php_header.php';
require_permission('task', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = (int)($_POST['id'] ?? 0);

  if ($id) {
    $origStmt = $pdo->prepare('SELECT * FROM module_tasks WHERE id = :id');
    $origStmt->execute([':id' => $id]);
    $existing = $origStmt->fetch(PDO::FETCH_ASSOC);
    if (!$existing) {
      echo json_encode(['success' => false]);
      exit;
    }

    $fields = [];
    $params = [
      ':uid' => $this_user_id,
      ':id'  => $id
    ];

    $validStatusIds   = array_column(get_lookup_items($pdo, 'TASK_STATUS'), 'id');
    $validPriorityIds = array_column(get_lookup_items($pdo, 'TASK_PRIORITY'), 'id');

    foreach (['name','description','requirements','specifications'] as $col) {
      if (array_key_exists($col, $_POST)) {
        $fields[] = "$col = :$col";
        $params[":$col"] = $_POST[$col];
      }
    }

    $fkTables = [
      'project_id'  => 'module_projects',
      'division_id' => 'module_division',
      'agency_id'   => 'module_agency'
    ];
    foreach ($fkTables as $col => $table) {
      if (array_key_exists($col, $_POST)) {
        $val = $_POST[$col];
        if ($val === '' || $val === null) {
          $fields[] = "$col = NULL";
        } else {
          $chk = $pdo->prepare("SELECT id FROM $table WHERE id = :val");
          $chk->execute([':val' => $val]);
          if ($chk->fetchColumn()) {
            $fields[] = "$col = :$col";
            $params[":$col"] = $val;
          }
        }
      }
    }

    if (array_key_exists('status', $_POST)) {
      $val = $_POST['status'];
      if ($val === '' || $val === null) {
        $fields[] = 'status = NULL';
      } elseif (in_array($val, $validStatusIds)) {
        $fields[] = 'status = :status';
        $params[':status'] = $val;
      }
    }

    if (array_key_exists('priority', $_POST)) {
      $val = $_POST['priority'];
      if ($val === '' || $val === null) {
        $fields[] = 'priority = NULL';
      } elseif (in_array($val, $validPriorityIds)) {
        $fields[] = 'priority = :priority';
        $params[':priority'] = $val;
      }
    }

    foreach (['start_date','due_date'] as $col) {
      if (array_key_exists($col, $_POST)) {
        $val = $_POST[$col];
        if ($val === '' || $val === null) {
          $fields[] = "$col = NULL";
        } else {
          $fields[] = "$col = :$col";
          $params[":$col"] = $val;
        }
      }
    }

    if (array_key_exists('completed', $_POST)) {
      $newCompleted = (int)($_POST['completed'] ? 1 : 0);
      $oldCompleted = (int)($existing['completed'] ?? 0);
      if ($newCompleted !== $oldCompleted) {
        if ($newCompleted === 1) {
          $fields[] = 'completed = 1';
          $fields[] = 'complete_date = NOW()';
          $fields[] = 'completed_by = :completed_by';
          $params[':completed_by'] = $this_user_id;
          $fields[] = 'progress_percent = 100';
        } else {
          $fields[] = 'completed = 0';
          $fields[] = 'complete_date = NULL';
          $fields[] = 'completed_by = NULL';
          $fields[] = 'progress_percent = 0';
        }
      } else {
        $fields[] = 'completed = :completed';
        $params[':completed'] = $newCompleted;
      }
    }

    if (array_key_exists('progress_percent', $_POST) && !array_key_exists('completed', $_POST)) {
      $pp = (int)$_POST['progress_percent'];
      if ($pp < 0) { $pp = 0; }
      if ($pp > 100) { $pp = 100; }
      $fields[] = 'progress_percent = :progress_percent';
      $params[':progress_percent'] = $pp;
    }

    if ($fields) {
      $sql = 'UPDATE module_tasks SET ' . implode(', ', $fields) . ', user_updated = :uid WHERE id = :id';
      $stmt = $pdo->prepare($sql);
      $stmt->execute($params);
      audit_log($pdo, $this_user_id, 'module_tasks', $id, 'UPDATE', 'Updated task');
    }

    $taskStmt = $pdo->prepare(
      'SELECT t.*, ' .
      'ls.label AS status_label, COALESCE(lsattr.attr_value, "secondary") AS status_color, ' .
      'lp.label AS priority_label, COALESCE(lpat.attr_value, "secondary") AS priority_color, ' .
      'p.name AS project_name, d.name AS division_name, a.name AS agency_name, ' .
      'o.name AS organization_name, ' .
      'CONCAT(cbper.first_name, " ", cbper.last_name) AS completed_by_name ' .
      'FROM module_tasks t ' .
      'LEFT JOIN lookup_list_items ls ON t.status = ls.id ' .
      'LEFT JOIN lookup_list_item_attributes lsattr ON ls.id = lsattr.item_id AND lsattr.attr_code = "COLOR-CLASS" ' .
      'LEFT JOIN lookup_list_items lp ON t.priority = lp.id ' .
      'LEFT JOIN lookup_list_item_attributes lpat ON lp.id = lpat.item_id AND lpat.attr_code = "COLOR-CLASS" ' .
      'LEFT JOIN module_projects p ON t.project_id = p.id ' .
      'LEFT JOIN module_division d ON t.division_id = d.id ' .
      'LEFT JOIN module_agency a ON t.agency_id = a.id ' .
      'LEFT JOIN module_organization o ON a.organization_id = o.id ' .
      'LEFT JOIN users cb ON t.completed_by = cb.id ' .
      'LEFT JOIN person cbper ON cb.id = cbper.user_id ' .
      'WHERE t.id = :id'
    );
    $taskStmt->execute([':id' => $id]);
    $taskRow = $taskStmt->fetch(PDO::FETCH_ASSOC) ?: [];
    echo json_encode(['success' => true, 'task' => $taskRow]);
    exit;
  }
}

echo json_encode(['success' => false]);
