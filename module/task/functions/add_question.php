<?php
require '../../../includes/php_header.php';
require_permission('task','create|update|delete');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$task_id = (int)($_POST['task_id'] ?? 0);
$question = trim($_POST['question_text'] ?? '');
if ($task_id && $question !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_tasks_questions (user_id,user_updated,task_id,question_text) VALUES (:uid,:uid,:tid,:question)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':tid' => $task_id,
    ':question' => $question
  ]);
  $questionId = $pdo->lastInsertId();
  admin_audit_log($pdo,$this_user_id,'module_tasks_questions',$questionId,'QUESTION','',$question);

  if (!empty($_FILES['files']) && is_array($_FILES['files']['name'])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir,0777,true);
    }
    foreach ($_FILES['files']['name'] as $idx => $name) {
      if ($_FILES['files']['error'][$idx] === UPLOAD_ERR_OK) {
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
        $targetName = 'task_' . $task_id . '_' . time() . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($_FILES['files']['tmp_name'][$idx], $targetPath)) {
          $filePathDb = '/module/task/uploads/' . $targetName;
          $stmtF = $pdo->prepare('INSERT INTO module_tasks_files (user_id,user_updated,task_id,question_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:tid,:qid,:name,:path,:size,:type)');
          $stmtF->execute([
            ':uid' => $this_user_id,
            ':tid' => $task_id,
            ':qid' => $questionId,
            ':name' => $baseName,
            ':path' => $filePathDb,
            ':size' => $_FILES['files']['size'][$idx],
            ':type' => $_FILES['files']['type'][$idx]
          ]);
          $fileId = $pdo->lastInsertId();
          admin_audit_log($pdo,$this_user_id,'module_tasks_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
        }
      }
    }
  }
}
header('Location: ../index.php?action=details&id=' . $task_id);
exit;
