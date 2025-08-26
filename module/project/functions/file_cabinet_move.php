<?php
require '../../../includes/php_header.php';
require_permission('project','update');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true) ?? [];

if(isset($input['create'])){
  $project_id = (int)($input['project_id'] ?? 0);
  $name       = trim($input['name'] ?? '');
  $pathStr    = trim($input['path'] ?? '');

  if(!$project_id || $name === ''){
    http_response_code(400);
    echo json_encode(['error'=>'Missing project_id or name']);
    exit;
  }

  $cleanPath = '';
  if($pathStr !== ''){
    $segments = array_filter(explode('/', $pathStr), 'strlen');
    $segments = array_map(fn($s) => preg_replace('/[^A-Za-z0-9._-]/','_', $s), $segments);
    $cleanPath = implode('/', $segments);
  }

  $parent_id = null;
  if($cleanPath !== ''){
    $stmt = $pdo->prepare('SELECT id FROM module_projects_folders WHERE project_id=:pid AND path=:path');
    $stmt->execute([':pid'=>$project_id, ':path'=>$cleanPath]);
    $parent_id = $stmt->fetchColumn();
    if($parent_id === false){
      http_response_code(404);
      echo json_encode(['error'=>'Parent path not found']);
      exit;
    }
  }else{
    $parent_id = get_project_root_folder($pdo,$project_id);
  }

  $_POST = [
    'project_id' => $project_id,
    'name'       => $name,
    'parent_id'  => $parent_id
  ];
  require 'create_folder.php';
  exit;
}

$id     = (int)($input['id'] ?? 0);
$parent = isset($input['parent']) && $input['parent'] !== '' ? (int)$input['parent'] : null;

if(!$id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing id']);
  exit;
}

$stmt = $pdo->prepare('SELECT id FROM module_projects_files WHERE id=:id');
$stmt->execute([':id'=>$id]);
if($stmt->fetchColumn()){
  $_POST = [
    'id' => $id,
    'target_folder_id' => $parent
  ];
  require 'move_file.php';
  exit;
}

$stmt = $pdo->prepare('SELECT id FROM module_projects_folders WHERE id=:id');
$stmt->execute([':id'=>$id]);
if($stmt->fetchColumn()){
  $_POST = [
    'id' => $id,
    'target_parent_id' => $parent
  ];
  require 'move_folder.php';
  exit;
}

http_response_code(404);
echo json_encode(['error'=>'Item not found']);
exit;
