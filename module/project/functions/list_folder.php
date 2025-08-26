<?php
require '../../../includes/php_header.php';
require_permission('project','view');

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

  $stmt = $pdo->prepare('SELECT id,name,path FROM module_projects_folders WHERE project_id=:pid AND parent_id'.($folder_id?'=:fid':' IS NULL').' ORDER BY name');
  $stmt->execute([':pid'=>$project_id, ':fid'=>$folder_id]);
  $folders = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type FROM module_projects_files WHERE project_id=:pid AND folder_id'.($folder_id?'=:fid':' IS NULL').' AND note_id IS NULL AND question_id IS NULL ORDER BY sort_order, date_created DESC');
  $stmt->execute([':pid'=>$project_id, ':fid'=>$folder_id]);
  $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode(['current'=>$current,'folders'=>$folders,'files'=>$files]);
}catch(PDOException $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
exit;

