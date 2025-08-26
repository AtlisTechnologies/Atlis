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
$stmt = $pdo->prepare('SELECT id,name,date_updated FROM module_projects_folders WHERE project_id=:pid AND parent_id'.($folder_id?'=:fid':' IS NULL').' ORDER BY name');
$stmt->execute([':pid'=>$project_id, ':fid'=>$folder_id]);
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
$stmt = $pdo->prepare('SELECT id,file_name,file_size,date_updated FROM module_projects_files WHERE project_id=:pid AND folder_id'.($folder_id?'=:fid':' IS NULL').' AND note_id IS NULL AND question_id IS NULL ORDER BY sort_order, date_created DESC');
$stmt->execute([':pid'=>$project_id, ':fid'=>$folder_id]);
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
exit;
