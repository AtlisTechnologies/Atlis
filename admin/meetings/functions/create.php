<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'create');

function get_default_lookup_item_id(PDO $pdo, string $listName): ?int {
  $sql = "SELECT li.id FROM lookup_list_items li\n            JOIN lookup_lists l ON li.list_id = l.id\n            JOIN lookup_list_item_attributes a ON a.item_id = li.id\n           WHERE l.name = :name\n             AND a.attr_code = 'DEFAULT'\n             AND a.attr_value = 'true'\n           LIMIT 1";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([':name' => $listName]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return $row['id'] ?? null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Content-Type: application/json');
  if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
  }
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $start_raw = $_POST['start_time'] ?? '';
  $end_raw = $_POST['end_time'] ?? '';
  $recur_daily = !empty($_POST['recur_daily']) ? 1 : 0;
  $recur_weekly = !empty($_POST['recur_weekly']) ? 1 : 0;
  $recur_monthly = !empty($_POST['recur_monthly']) ? 1 : 0;
  $meeting_status_id = isset($_POST['status_id']) && $_POST['status_id'] !== '' ? (int)$_POST['status_id'] : null;
  $meeting_type_id   = isset($_POST['type_id']) && $_POST['type_id'] !== '' ? (int)$_POST['type_id'] : null;
  $calendar_event_id = isset($_POST['calendar_event_id']) && $_POST['calendar_event_id'] !== '' ? (int)$_POST['calendar_event_id'] : null;

  if (!$meeting_status_id) {
    $meeting_status_id = get_default_lookup_item_id($pdo, 'MEETING_STATUS');
  }
  if (!$meeting_type_id) {
    $meeting_type_id = get_default_lookup_item_id($pdo, 'MEETING_TYPE');
  }

  $errors = [];
  if ($title === '') {
    $errors[] = 'Title is required';
  }
  $start_dt = DateTime::createFromFormat('Y-m-d\\TH:i', $start_raw);
  if (!$start_dt) {
    $errors[] = 'Invalid start time';
  }
  $end_dt = null;
  if ($end_raw !== '') {
    $end_dt = DateTime::createFromFormat('Y-m-d\\TH:i', $end_raw);
    if (!$end_dt) {
      $errors[] = 'Invalid end time';
    } elseif ($start_dt && $end_dt <= $start_dt) {
      $errors[] = 'End time must be after start time';
    }
  } elseif ($start_dt) {
    $intervalVal = get_system_property($pdo, 'ADMIN_MEETING_DEFAULT_END_DATE');
    if ($intervalVal) {
      $end_dt = clone $start_dt;
      try {
        $end_dt->add(new DateInterval($intervalVal));
      } catch (Exception $e) {
        $end_dt->modify('+' . $intervalVal);
      }
    }
  }

  if (empty($errors)) {
    try {
      $pdo->beginTransaction();
      $start_time = $start_dt ? $start_dt->format('Y-m-d H:i:s') : null;
      $end_time = $end_dt ? $end_dt->format('Y-m-d H:i:s') : null;

      $stmt = $pdo->prepare('INSERT INTO module_meetings (user_id, user_updated, title, description, start_time, end_time, recur_daily, recur_weekly, recur_monthly, calendar_event_id, status_id, type_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
      $stmt->execute([$this_user_id, $this_user_id, $title, $description, $start_time, $end_time, $recur_daily, $recur_weekly, $recur_monthly, $calendar_event_id, $meeting_status_id, $meeting_type_id]);
      $id = $pdo->lastInsertId();
      admin_audit_log($pdo, $this_user_id, 'module_meeting', $id, 'CREATE', '', json_encode(['title'=>$title]), 'Created meeting');

      // Agenda items
      $agenda_titles = isset($_POST['agenda_title']) && is_array($_POST['agenda_title']) ? $_POST['agenda_title'] : [];
      $agenda_status_ids = isset($_POST['agenda_status_id']) && is_array($_POST['agenda_status_id']) ? $_POST['agenda_status_id'] : [];
      $agenda_order_indexes = isset($_POST['agenda_order_index']) && is_array($_POST['agenda_order_index']) ? $_POST['agenda_order_index'] : [];
      $agenda_linked_task_ids = isset($_POST['agenda_linked_task_id']) && is_array($_POST['agenda_linked_task_id']) ? $_POST['agenda_linked_task_id'] : [];
      $agenda_linked_project_ids = isset($_POST['agenda_linked_project_id']) && is_array($_POST['agenda_linked_project_id']) ? $_POST['agenda_linked_project_id'] : [];

      $agendaStmt = $pdo->prepare('INSERT INTO module_meeting_agenda (user_id, user_updated, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id) VALUES (:uid,:uid,:mid,:order_index,:title,:status_id,:task_id,:project_id)');
      $agenda_count = count($agenda_titles);
      $defaultAgendaStatusId = $agenda_count ? get_default_lookup_item_id($pdo, 'MEETING_AGENDA_STATUS') : null;
      for ($i = 0; $i < $agenda_count; $i++) {
        $aTitle = trim($agenda_titles[$i] ?? '');
        if ($aTitle === '') { continue; }
        $order_index = isset($agenda_order_indexes[$i]) && $agenda_order_indexes[$i] !== '' ? (int)$agenda_order_indexes[$i] : $i + 1;
        $status_id = isset($agenda_status_ids[$i]) && $agenda_status_ids[$i] !== '' ? (int)$agenda_status_ids[$i] : $defaultAgendaStatusId;
        $task_id = isset($agenda_linked_task_ids[$i]) && $agenda_linked_task_ids[$i] !== '' ? (int)$agenda_linked_task_ids[$i] : null;
        $project_id = isset($agenda_linked_project_ids[$i]) && $agenda_linked_project_ids[$i] !== '' ? (int)$agenda_linked_project_ids[$i] : null;
        $agendaStmt->execute([
          ':uid' => $this_user_id,
          ':mid' => $id,
          ':order_index' => $order_index,
          ':title' => $aTitle,
          ':status_id' => $status_id,
          ':task_id' => $task_id,
          ':project_id' => $project_id
        ]);
        $agendaId = $pdo->lastInsertId();
        admin_audit_log($pdo, $this_user_id, 'module_meeting_agenda', $agendaId, 'CREATE', '', json_encode(['title'=>$aTitle]), 'Added agenda item');
      }

      // Questions
      $question_texts = isset($_POST['question_text']) && is_array($_POST['question_text']) ? $_POST['question_text'] : [];
      $answer_texts = isset($_POST['answer_text']) && is_array($_POST['answer_text']) ? $_POST['answer_text'] : [];
      $question_agenda_ids = isset($_POST['agenda_id']) && is_array($_POST['agenda_id']) ? $_POST['agenda_id'] : [];
      $question_status_ids = $_POST['question_status_id'] ?? [];

      $questionStmt = $pdo->prepare('INSERT INTO module_meeting_questions (user_id, user_updated, meeting_id, agenda_id, question_text, answer_text, status_id) VALUES (:uid,:uid,:mid,:aid,:q,:a,:status)');
      $question_count = count($question_texts);
      for ($i = 0; $i < $question_count; $i++) {
        $qText = trim($question_texts[$i] ?? '');
        if ($qText === '') { continue; }
        $aText = trim($answer_texts[$i] ?? '');
        $agenda_id = isset($question_agenda_ids[$i]) && $question_agenda_ids[$i] !== '' ? (int)$question_agenda_ids[$i] : null;
        $status_id = isset($question_status_ids[$i]) && $question_status_ids[$i] !== '' ? (int)$question_status_ids[$i] : null;
        $questionStmt->execute([
          ':uid' => $this_user_id,
          ':mid' => $id,
          ':aid' => $agenda_id,
          ':q' => $qText,
          ':a' => $aText,
          ':status' => $status_id
        ]);
        $questionId = $pdo->lastInsertId();
        admin_audit_log($pdo, $this_user_id, 'module_meeting_questions', $questionId, 'CREATE', '', json_encode(['question'=>$qText]), 'Added question');
      }

      // Attendees
      $attendee_user_ids = isset($_POST['attendee_user_id']) && is_array($_POST['attendee_user_id']) ? $_POST['attendee_user_id'] : [];

      $attendeeStmt = $pdo->prepare('INSERT INTO module_meeting_attendees (user_id, user_updated, meeting_id, attendee_user_id) VALUES (:uid,:uid,:mid,:attendee)');
      $attendee_count = count($attendee_user_ids);
      for ($i = 0; $i < $attendee_count; $i++) {
        $attendee_id = isset($attendee_user_ids[$i]) && $attendee_user_ids[$i] !== '' ? (int)$attendee_user_ids[$i] : null;
        if (!$attendee_id) { continue; }
        $attendeeStmt->execute([
          ':uid' => $this_user_id,
          ':mid' => $id,
          ':attendee' => $attendee_id
        ]);
        $attendeeId = $pdo->lastInsertId();
        admin_audit_log($pdo, $this_user_id, 'module_meeting_attendees', $attendeeId, 'CREATE', '', json_encode(['user_id'=>$attendee_id]), 'Added attendee');
      }

      // Files
      if (!empty($_FILES['files'])) {
        $uploadDir = dirname(__DIR__) . '/uploads/' . $id . '/';
        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        }
        $files = $_FILES['files'];
        if (!is_array($files['name'])) {
          $files = [
            'name' => [$files['name']],
            'type' => [$files['type']],
            'tmp_name' => [$files['tmp_name']],
            'error' => [$files['error']],
            'size' => [$files['size']]
          ];
        }
        $allowedImages = array_column(get_lookup_items($pdo, 'IMAGE_FILE_TYPES'), 'code');
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        foreach ($files['name'] as $index => $name) {
          if ($files['error'][$index] !== UPLOAD_ERR_OK) { continue; }
          $mime = finfo_file($finfo, $files['tmp_name'][$index]);
          if (strpos($mime, 'image/') === 0 && !in_array($mime, $allowedImages, true)) { continue; }
          $baseName = basename($name);
          $safeName = preg_replace('/[^A-Za-z0-9._-]/', '_', $baseName);
          $targetName = 'meeting_' . $id . '_' . time() . '_' . $safeName;
          $targetPath = $uploadDir . $targetName;
          if (move_uploaded_file($files['tmp_name'][$index], $targetPath)) {
            $filePathDb = '/admin/meetings/uploads/' . $id . '/' . $targetName;
            $fileStmt = $pdo->prepare('INSERT INTO module_meeting_files (user_id,user_updated,meeting_id,file_name,file_path,uploader_id) VALUES (:uid,:uid,:mid,:name,:path,:uid)');
            $fileStmt->execute([
              ':uid' => $this_user_id,
              ':mid' => $id,
              ':name' => $baseName,
              ':path' => $filePathDb
            ]);
            $fileId = $pdo->lastInsertId();
            admin_audit_log($pdo, $this_user_id, 'module_meeting_files', $fileId, 'UPLOAD', '', json_encode(['file'=>$baseName]), 'Uploaded file');
          }
        }
        finfo_close($finfo);
      }

      $pdo->commit();
      $redirect = $_POST['redirect'] ?? ('../index.php?action=edit&id=' . $id);
      echo json_encode(['success'=>true,'id'=>$id,'redirect'=>$redirect]);
      exit;
    } catch (Exception $e) {
      $pdo->rollBack();
      $errors[] = $e->getMessage();
    }
  }
  echo json_encode(['success'=>false,'errors'=>$errors,'message'=>($errors[0] ?? 'Unable to create meeting')]);
  exit;
}

header('Content-Type: application/json');
echo json_encode(['success'=>false]);
exit;
