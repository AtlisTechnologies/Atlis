<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'create');

$isAjax = isset($_POST['ajax']) || (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false);
if ($isAjax) {
  header('Content-Type: application/json');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  if ($title === '') {
    $title = 'Meeting ' . bin2hex(random_bytes(2));
  }
  $meeting_date = $_POST['meeting_date'] ?? null;
  $stmt = $pdo->prepare('INSERT INTO module_meeting (user_id, user_updated, title, meeting_date) VALUES (?,?,?,?)');
  $stmt->execute([$this_user_id, $this_user_id, $title, $meeting_date]);
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_meeting', $id, 'CREATE', 'Created meeting');
  $meeting = ['id'=>$id,'title'=>$title,'meeting_date'=>$meeting_date];
  if ($isAjax) {
    echo json_encode(['success'=>true,'meeting'=>$meeting]);
    exit;
  }
}

if ($isAjax) {
  echo json_encode(['success'=>false]);
  exit;
}

header('Location: ../index.php');
exit;
