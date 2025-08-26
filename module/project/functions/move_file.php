<?php
require '../../../includes/php_header.php';
require_permission('project','update');

$file_id = (int)($_POST['id'] ?? 0);
$target_folder_id = isset($_POST['target_folder_id']) && $_POST['target_folder_id'] !== '' ? (int)$_POST['target_folder_id'] : null;

header('Content-Type: application/json');

if(!$file_id){
  http_response_code(400);
  echo json_encode(['error'=>'Missing file id']);
  exit;
}

$stmt = $pdo->prepare('SELECT id,project_id,file_path,file_name,folder_id FROM module_projects_files WHERE id=:id');
$stmt->execute([':id'=>$file_id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$file){
  http_response_code(404);
  echo json_encode(['error'=>'File not found']);
  exit;
}

$newPathPart = get_project_folder_path($pdo,$target_folder_id);
$oldFullPath = dirname(__DIR__,3) . $file['file_path'];
$newRelPath = '/module/project/uploads/' . $file['project_id'] . '/' . ($newPathPart !== '' ? $newPathPart . '/' : '') . basename($file['file_path']);
$newFullPath = dirname(__DIR__,3) . $newRelPath;

if(!is_dir(dirname($newFullPath))){
  mkdir(dirname($newFullPath),0777,true);
}

if(!@rename($oldFullPath,$newFullPath)){
  http_response_code(500);
  echo json_encode(['error'=>'Move failed']);
  exit;
}

$pdo->prepare('UPDATE module_projects_files SET folder_id=:fid,file_path=:path,user_updated=:uid WHERE id=:id')->execute([
  ':fid'=>$target_folder_id,
  ':path'=>$newRelPath,
  ':uid'=>$this_user_id,
  ':id'=>$file_id
]);

admin_audit_log($pdo,$this_user_id,'module_projects_files',$file_id,'MOVE',$file['file_path'],$newRelPath);

echo json_encode(['success'=>true,'path'=>$newRelPath]);
exit;

