<?php
require '../../../includes/php_header.php';
require_permission('project','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$project_id = (int)($_POST['project_id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$parent_id = isset($_POST['parent_id']) && $_POST['parent_id'] !== '' ? (int)$_POST['parent_id'] : null;

header('Content-Type: application/json');

if(!$project_id || $name === ''){
  http_response_code(400);
  echo json_encode(['error' => 'Missing project_id or name']);
  exit;
}
try{
  $maxFolders = (int)get_system_property($pdo,'PROJECT_FILE_MAX_FOLDER_COUNT');
  if($maxFolders){
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM module_projects_folders WHERE project_id=:pid');
    $stmt->execute([':pid'=>$project_id]);
    if($stmt->fetchColumn() >= $maxFolders){
      http_response_code(400);
      echo json_encode(['error'=>'Folder limit reached']);
      exit;
    }
  }


  $parentPath = '';
  if($parent_id){
    $stmt = $pdo->prepare('SELECT path FROM module_projects_folders WHERE id=:id AND project_id=:pid');
    $stmt->execute([':id'=>$parent_id, ':pid'=>$project_id]);
    $parentPath = $stmt->fetchColumn();
    if($parentPath === false){
      http_response_code(404);
      echo json_encode(['error'=>'Parent folder not found']);
      exit;
    }
  }

  $maxDepth = (int)get_system_property($pdo,'PROJECT_FILE_MAX_FOLDER_DEPTH');
  if($maxDepth){
    $parentDepth = $parentPath === '' ? 0 : substr_count($parentPath,'/') + 1;
    if($parentDepth + 1 > $maxDepth){
      http_response_code(400);
      echo json_encode(['error'=>'Folder depth exceeded']);
      exit;
    }
  }

  $safeName = preg_replace('/[^A-Za-z0-9._-]/','_', $name);
  $newPath = ($parentPath !== '' ? $parentPath . '/' : '') . $safeName;

  $stmt = $pdo->prepare('SELECT id FROM module_projects_folders WHERE project_id=:pid AND path=:path');
  $stmt->execute([':pid'=>$project_id, ':path'=>$newPath]);
  if($stmt->fetchColumn()){
    http_response_code(400);
    echo json_encode(['error'=>'Folder already exists']);
    exit;
  }

  $baseDir = dirname(__DIR__) . '/uploads/' . $project_id . '/' . ($parentPath !== '' ? $parentPath . '/' : '');
  if(!is_dir($baseDir.$safeName)){
    mkdir($baseDir.$safeName,0777,true);
  }

  $stmt = $pdo->prepare('INSERT INTO module_projects_folders (user_id,user_updated,project_id,parent_id,name,path) VALUES (:uid,:uid,:pid,:parent,:name,:path)');
  $stmt->execute([
    ':uid'=>$this_user_id,
    ':pid'=>$project_id,
    ':parent'=>$parent_id,
    ':name'=>$safeName,
    ':path'=>$newPath
  ]);
  $fid = $pdo->lastInsertId();

  admin_audit_log($pdo,$this_user_id,'module_projects_folders',$fid,'CREATE','',json_encode(['name'=>$safeName,'parent_id'=>$parent_id]));

  echo json_encode(['id'=>$fid,'name'=>$safeName,'path'=>$newPath]);
}catch(PDOException $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
exit;

