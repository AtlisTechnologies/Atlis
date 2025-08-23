<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$project_id = (int)($_POST['project_id'] ?? 0);
$question_text = trim($_POST['question_text'] ?? '');

if ($project_id && $question_text !== '') {
  $stmt = $pdo->prepare('INSERT INTO module_projects_questions (user_id,user_updated,project_id,question_text) VALUES (:uid,:uid,:pid,:question)');
  $stmt->execute([
    ':uid' => $this_user_id,
    ':pid' => $project_id,
    ':question' => $question_text
  ]);
  $questionId = $pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_projects_questions', $questionId, 'QUESTION', '', $question_text);

  if (!empty($_FILES['files']) && is_array($_FILES['files']['name'])) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir,0777,true);
    }
    foreach ($_FILES['files']['name'] as $idx => $name) {
      if ($_FILES['files']['error'][$idx] === UPLOAD_ERR_OK) {
        $baseName = basename($name);
        $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $baseName);
        $targetName = 'project_' . $project_id . '_' . time() . '_' . $idx . '_' . $safeName;
        $targetPath = $uploadDir . $targetName;
        if (move_uploaded_file($_FILES['files']['tmp_name'][$idx], $targetPath)) {
          $filePathDb = '/module/project/uploads/' . $targetName;
          $stmtF = $pdo->prepare('INSERT INTO module_projects_files (user_id,user_updated,project_id,question_id,file_name,file_path,file_size,file_type) VALUES (:uid,:uid,:pid,:qid,:name,:path,:size,:type)');
          $stmtF->execute([
            ':uid' => $this_user_id,
            ':pid' => $project_id,
            ':qid' => $questionId,
            ':name' => $baseName,
            ':path' => $filePathDb,
            ':size' => $_FILES['files']['size'][$idx],
            ':type' => $_FILES['files']['type'][$idx]
          ]);
          $fileId = $pdo->lastInsertId();
          admin_audit_log($pdo,$this_user_id,'module_projects_files',$fileId,'UPLOAD','',json_encode(['file'=>$baseName]));
        }
      }
    }
  }
}

header('Location: ../index.php?action=details&id=' . $project_id . '#questions');
exit;
?>
