<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'create');

$isAjax = isset($_POST['ajax']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
if ($isAjax) {
  header('Content-Type: application/json');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $description = trim($_POST['description'] ?? '');
  $start_raw = $_POST['start_time'] ?? '';
  $end_raw = $_POST['end_time'] ?? '';
  $recur_daily = !empty($_POST['recur_daily']) ? 1 : 0;
  $recur_weekly = !empty($_POST['recur_weekly']) ? 1 : 0;
  $recur_monthly = !empty($_POST['recur_monthly']) ? 1 : 0;

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
  }

  if (empty($errors)) {
    try {
      $pdo->beginTransaction();
      $start_time = $start_dt ? $start_dt->format('Y-m-d H:i:s') : null;
      $end_time = $end_dt ? $end_dt->format('Y-m-d H:i:s') : null;

      $stmt = $pdo->prepare('INSERT INTO module_meetings (user_id, user_updated, title, description, start_time, end_time, recur_daily, recur_weekly, recur_monthly) VALUES (?,?,?,?,?,?,?,?,?)');
      $stmt->execute([$this_user_id, $this_user_id, $title, $description, $start_time, $end_time, $recur_daily, $recur_weekly, $recur_monthly]);
      $id = $pdo->lastInsertId();
      admin_audit_log($pdo, $this_user_id, 'module_meeting', $id, 'CREATE', '', 'Created meeting');

      // Agenda items
      $agenda_titles = isset($_POST['agenda_title']) && is_array($_POST['agenda_title']) ? $_POST['agenda_title'] : [];
      $agenda_status_ids = isset($_POST['agenda_status_id']) && is_array($_POST['agenda_status_id']) ? $_POST['agenda_status_id'] : [];
      $agenda_order_indexes = isset($_POST['agenda_order_index']) && is_array($_POST['agenda_order_index']) ? $_POST['agenda_order_index'] : [];
      $agenda_linked_task_ids = isset($_POST['agenda_linked_task_id']) && is_array($_POST['agenda_linked_task_id']) ? $_POST['agenda_linked_task_id'] : [];
      $agenda_linked_project_ids = isset($_POST['agenda_linked_project_id']) && is_array($_POST['agenda_linked_project_id']) ? $_POST['agenda_linked_project_id'] : [];

      $agendaStmt = $pdo->prepare('INSERT INTO module_meeting_agenda (user_id, user_updated, meeting_id, order_index, title, status_id, linked_task_id, linked_project_id) VALUES (:uid,:uid,:mid,:order_index,:title,:status_id,:task_id,:project_id)');
      $agenda_count = count($agenda_titles);
      for ($i = 0; $i < $agenda_count; $i++) {
        $aTitle = trim($agenda_titles[$i] ?? '');
        if ($aTitle === '') { continue; }
        $order_index = isset($agenda_order_indexes[$i]) && $agenda_order_indexes[$i] !== '' ? (int)$agenda_order_indexes[$i] : $i + 1;
        $status_id = isset($agenda_status_ids[$i]) && $agenda_status_ids[$i] !== '' ? (int)$agenda_status_ids[$i] : null;
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
        admin_audit_log($pdo, $this_user_id, 'module_meeting_agenda', $agendaId, 'CREATE', '', $aTitle);
      }

      // Questions
      $question_texts = isset($_POST['question_text']) && is_array($_POST['question_text']) ? $_POST['question_text'] : [];
      $answer_texts = isset($_POST['answer_text']) && is_array($_POST['answer_text']) ? $_POST['answer_text'] : [];
      $question_agenda_ids = isset($_POST['agenda_id']) && is_array($_POST['agenda_id']) ? $_POST['agenda_id'] : [];
      $question_status_ids = isset($_POST['status_id']) && is_array($_POST['status_id']) ? $_POST['status_id'] : [];

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
        admin_audit_log($pdo, $this_user_id, 'module_meeting_questions', $questionId, 'CREATE', '', $qText);
      }

      $pdo->commit();
      $meeting = ['id'=>$id,'title'=>$title,'start_time'=>$start_time];
    } catch (Exception $e) {
      $pdo->rollBack();
      $errors[] = $e->getMessage();
    }
  }

  if ($isAjax) {
    if (empty($errors)) {
      echo json_encode(['success'=>true,'meeting'=>$meeting]);
    } else {
      echo json_encode(['success'=>false,'errors'=>$errors]);
    }
    exit;
  } else {
    if (empty($errors)) {
      header('Location: ../index.php');
    } else {
      echo implode('\n', $errors);
    }
    exit;
  }
}

if ($isAjax) {
  echo json_encode(['success'=>false]);
  exit;
}

header('Location: ../index.php');
exit;
