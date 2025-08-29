<?php
require '../../../includes/php_header.php';
require_permission('project','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$folder_id = (int)($_POST['id'] ?? 0);
$target_parent_id = isset($_POST['target_parent_id']) && $_POST['target_parent_id'] !== '' ? (int)$_POST['target_parent_id'] : null;

header('Content-Type: application/json');

if(!$folder_id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing folder id']);
  exit;
}
try{
  $stmt = $pdo->prepare('SELECT id,project_id,name,path,parent_id FROM module_projects_folders WHERE id=:id');
  $stmt->execute([':id'=>$folder_id]);
  $folder = $stmt->fetch(PDO::FETCH_ASSOC);
  if(!$folder){
    http_response_code(404);
    echo json_encode(['error'=>'Folder not found']);
    exit;
  }
  if($folder['parent_id'] === null && $folder['path'] === ''){
    http_response_code(400);
    echo json_encode(['error'=>'Cannot move root']);
    exit;
  }

  $targetPath = '';
  if($target_parent_id){
    if($target_parent_id == $folder_id){
      http_response_code(400);
      echo json_encode(['error'=>'Invalid target']);
      exit;
    }
    $stmt = $pdo->prepare('SELECT id,path FROM module_projects_folders WHERE id=:id AND project_id=:pid');
    $stmt->execute([':id'=>$target_parent_id, ':pid'=>$folder['project_id']]);
    $target = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$target){
      http_response_code(404);
      echo json_encode(['error'=>'Target folder not found']);
      exit;
    }
    if(str_starts_with($target['path'],$folder['path'].'/')){
      http_response_code(400);
      echo json_encode(['error'=>'Cannot move into descendant']);
      exit;
    }
    $targetPath = $target['path'];
  }

  $maxDepth = (int)get_system_property($pdo,'PROJECT_FILE_MAX_FOLDER_DEPTH');
  if($maxDepth){
    $targetDepth = $targetPath === '' ? 0 : substr_count($targetPath,'/') + 1;
    $folderDepth = $folder['path'] === '' ? 0 : substr_count($folder['path'],'/') + 1;
    $newDepth = $targetDepth + 1; // depth of moved folder root
    if($newDepth > $maxDepth){
      http_response_code(400);
      echo json_encode(['error'=>'Folder depth exceeded']);
      exit;
    }
  }

  $oldPath = $folder['path'];
  $newPath = ($targetPath !== '' ? $targetPath . '/' : '') . $folder['name'];

  $baseDir = dirname(__DIR__) . '/uploads/' . $folder['project_id'] . '/';
  $oldFull = $baseDir . $oldPath;
  $newFull = $baseDir . $newPath;
  if(!is_dir(dirname($newFull))){
    mkdir(dirname($newFull),0777,true);
  }
  if(!@rename($oldFull,$newFull)){
    http_response_code(500);
    echo json_encode(['error'=>'Move failed']);
    exit;
  }

  $pdo->prepare('UPDATE module_projects_folders SET parent_id=:pid,path=:path,user_updated=:uid WHERE id=:id')->execute([
    ':pid'=>$target_parent_id,
    ':path'=>$newPath,
    ':uid'=>$this_user_id,
    ':id'=>$folder_id
  ]);

  $oldPrefix = '/module/project/uploads/' . $folder['project_id'] . '/' . $oldPath;
  $newPrefix = '/module/project/uploads/' . $folder['project_id'] . '/' . $newPath;
  $like = $oldPrefix . '%';
  $pdo->prepare('UPDATE module_projects_files SET file_path = REPLACE(file_path,:old,:new) WHERE project_id=:pid AND file_path LIKE :like')->execute([
    ':old'=>$oldPrefix,
    ':new'=>$newPrefix,
    ':pid'=>$folder['project_id'],
    ':like'=>$like
  ]);

  $pdo->prepare('UPDATE module_projects_folders SET path = REPLACE(path,:old,:new) WHERE project_id=:pid AND path LIKE :oldlike')->execute([
    ':old'=>$oldPath.'/',
    ':new'=>$newPath.'/',
    ':pid'=>$folder['project_id'],
    ':oldlike'=>$oldPath.'/%'
  ]);

  admin_audit_log($pdo,$this_user_id,'module_projects_folders',$folder_id,'MOVE',$oldPath,$newPath);

  echo json_encode(['success'=>true,'path'=>$newPath]);
}catch(PDOException $e){
  http_response_code(500);
  echo json_encode(['error'=>$e->getMessage()]);
}
exit;

