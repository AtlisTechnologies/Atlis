<?php
require '../../../includes/php_header.php';
require_permission('project','update');
if (!verify_csrf_token($_POST["csrf_token"] ?? $_GET["csrf_token"] ?? null)) { http_response_code(403); exit("Forbidden"); }

$folder_id = (int)($_POST['id'] ?? 0);
$project_id = (int)($_POST['project_id'] ?? 0);

header('Content-Type: application/json');

if(!$folder_id || !$project_id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing folder or project']);
  exit;
}

$stmt = $pdo->prepare('SELECT id, parent_id, path FROM module_projects_folders WHERE id=:id AND project_id=:pid');
$stmt->execute([':id'=>$folder_id, ':pid'=>$project_id]);
$folder = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$folder || !$folder_id || $folder['parent_id'] === null && $folder['path'] === ''){
  http_response_code(404);
  echo json_encode(['error'=>'Folder not found']);
  exit;
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM module_projects_folders WHERE parent_id=:id');
$stmt->execute([':id'=>$folder_id]);
if($stmt->fetchColumn() > 0){
  http_response_code(400);
  echo json_encode(['error'=>'Folder not empty']);
  exit;
}

$stmt = $pdo->prepare('SELECT COUNT(*) FROM module_projects_files WHERE folder_id=:id');
$stmt->execute([':id'=>$folder_id]);
if($stmt->fetchColumn() > 0){
  http_response_code(400);
  echo json_encode(['error'=>'Folder not empty']);
  exit;
}

$dir = dirname(__DIR__) . '/uploads/' . $project_id . '/' . $folder['path'];
if(is_dir($dir)){
  rmdir($dir);
}

$pdo->prepare('DELETE FROM module_projects_folders WHERE id=:id')->execute([':id'=>$folder_id]);
admin_audit_log($pdo,$this_user_id,'module_projects_folders',$folder_id,'DELETE','',json_encode(['path'=>$folder['path']]));

echo json_encode(['success'=>true]);
exit;

