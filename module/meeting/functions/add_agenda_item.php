<?php
require '../../../includes/php_header.php';
require_permission('meeting', 'update');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $meeting_id = (int)($_POST['meeting_id'] ?? 0);
  $title = trim($_POST['title'] ?? '');
  $presenter = trim($_POST['presenter'] ?? '');
  $duration = (int)($_POST['duration'] ?? 0);
  $posStmt = $pdo->prepare('SELECT COALESCE(MAX(position),0)+1 FROM module_meeting_agenda WHERE meeting_id=?');
  $posStmt->execute([$meeting_id]);
  $position = (int)$posStmt->fetchColumn();
  $stmt = $pdo->prepare('INSERT INTO module_meeting_agenda (user_id, user_updated, meeting_id, title, presenter, duration, position) VALUES (?,?,?,?,?,?,?)');
  $stmt->execute([$this_user_id, $this_user_id, $meeting_id, $title, $presenter, $duration, $position]);
  $id = $pdo->lastInsertId();
  audit_log($pdo, $this_user_id, 'module_meeting_agenda', $id, 'CREATE', 'Added agenda item');
  echo json_encode(['success'=>true,'item'=>['id'=>$id,'title'=>$title,'presenter'=>$presenter,'duration'=>$duration]]);
  exit;
}

echo json_encode(['success'=>false]);
