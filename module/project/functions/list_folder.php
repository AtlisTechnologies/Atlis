<?php
require '../../../includes/php_header.php';
require_permission('project','view');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$project_id = (int)($_GET['project_id'] ?? 0);
$folder_id = isset($_GET['folder_id']) && $_GET['folder_id'] !== '' ? (int)$_GET['folder_id'] : null;

header('Content-Type: application/json');

if(!$project_id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing project_id']);
  exit;
}

if(!$folder_id){
  $folder_id = get_project_root_folder($pdo,$project_id);
}
try{
  $current = null;
  if($folder_id){
    $stmt = $pdo->prepare('SELECT id,name,path FROM module_projects_folders WHERE id=:id AND project_id=:pid');
    $stmt->execute([':id'=>$folder_id, ':pid'=>$project_id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  $folderSql = 'SELECT id,name,path FROM module_projects_folders WHERE project_id=:pid AND ';
  $folderParams = [':pid' => $project_id];
  if($folder_id === null){
    $folderSql .= 'parent_id IS NULL';
  }else{
    $folderSql .= 'parent_id = :fid';
    $folderParams[':fid'] = $folder_id;
  }
  $folderSql .= ' ORDER BY name';
  $stmt = $pdo->prepare($folderSql);
  $stmt->execute($folderParams);
  $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $fileSql = 'SELECT id,file_name,file_path,file_size,file_type FROM module_projects_files WHERE project_id=:pid AND ';
  $fileParams = [':pid' => $project_id];
  if($folder_id === null){
    $fileSql .= 'folder_id IS NULL';
  }else{
    $fileSql .= 'folder_id = :fid';
    $fileParams[':fid'] = $folder_id;
  }
  $fileSql .= ' AND note_id IS NULL AND question_id IS NULL ORDER BY sort_order, date_created DESC';
  $stmt = $pdo->prepare($fileSql);
  $stmt->execute($fileParams);
  $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['current'=>$current,'folders'=>$folders,'files'=>$files]);
}catch(PDOException $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
exit;

