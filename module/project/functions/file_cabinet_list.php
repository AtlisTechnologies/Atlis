<?php
require '../../../includes/php_header.php';
require_permission('project','view');

$project_id = (int)($_GET['project_id'] ?? 0);
$pathStr    = trim($_GET['path'] ?? '');

header('Content-Type: application/json');

if(!$project_id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing project_id']);
  exit;
}
try{
  // Sanitize path segments similar to create_folder.php
  $cleanPath = '';
  if($pathStr !== ''){
    $segments = array_filter(explode('/', $pathStr), 'strlen');
    $segments = array_map(fn($s) => preg_replace('/[^A-Za-z0-9._-]/','_', $s), $segments);
    $cleanPath = implode('/', $segments);
  }

  $folder_id = null;
  if($cleanPath !== ''){
    $stmt = $pdo->prepare('SELECT id FROM module_projects_folders WHERE project_id=:pid AND path=:path');
    $stmt->execute([':pid'=>$project_id, ':path'=>$cleanPath]);
    $folder_id = $stmt->fetchColumn();
    if($folder_id === false){
      http_response_code(404);
      echo json_encode(['error'=>'Folder not found']);
      exit;
    }
  }else{
    $folder_id = get_project_root_folder($pdo,$project_id);
  }

  $files = [];
  // folders
  $folderSql = 'SELECT id,name,date_updated FROM module_projects_folders WHERE project_id=:pid AND ';
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
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $files[] = [
      'id'       => (int)$row['id'],
      'type'     => 'folder',
      'name'     => $row['name'],
      'size'     => null,
      'modified' => $row['date_updated']
    ];
  }

  // files
  $fileSql = 'SELECT id,file_name,file_size,date_updated FROM module_projects_files WHERE project_id=:pid AND ';
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
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    $files[] = [
      'id'       => (int)$row['id'],
      'type'     => 'file',
      'name'     => $row['file_name'],
      'size'     => $row['file_size'],
      'modified' => $row['date_updated']
    ];
  }

  echo json_encode(['files'=>$files]);
}catch(PDOException $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
exit;
