<?php
require '../../../includes/php_header.php';
require_permission('project','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

header('Content-Type: application/json');

$id = (int)($_POST['id'] ?? 0);
$question_id = (int)($_POST['question_id'] ?? 0);
$answer_text = trim($_POST['answer_text'] ?? '');

if ($id && $question_id && $answer_text !== '') {
  $stmt = $pdo->prepare('SELECT user_id, answer_text FROM module_projects_answers WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($row && ($is_admin || $row['user_id'] == $this_user_id)) {
    $upd = $pdo->prepare('UPDATE module_projects_answers SET answer_text = :text, user_updated = :uid WHERE id = :id');
    $upd->execute([':text' => $answer_text, ':uid' => $this_user_id, ':id' => $id]);
    admin_audit_log($pdo, $this_user_id, 'module_projects_answers', $id, 'UPDATE', $row['answer_text'], $answer_text);
    echo json_encode(['success' => true, 'answer_text' => $answer_text]);
    exit;
  }
}

echo json_encode(['success' => false]);
