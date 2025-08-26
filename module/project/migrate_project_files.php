<?php
// CLI script to migrate project files into folder structure
require '../../includes/php_header.php';

if(php_sapi_name() !== 'cli'){
  echo "CLI only\n";
  exit;
}

$projects = $pdo->query('SELECT id FROM module_projects')->fetchAll(PDO::FETCH_COLUMN);
foreach($projects as $pid){
  $stmt = $pdo->prepare('SELECT id FROM module_projects_folders WHERE project_id=:pid AND parent_id IS NULL');
  $stmt->execute([':pid'=>$pid]);
  $root = $stmt->fetchColumn();
  if(!$root){
    $pdo->prepare('INSERT INTO module_projects_folders (user_id,user_updated,project_id,parent_id,name,path) VALUES (0,0,:pid,NULL,"","")')->execute([':pid'=>$pid]);
    $root = $pdo->lastInsertId();
  }
  $dir = __DIR__ . '/uploads/' . $pid . '/';
  if(!is_dir($dir)){
    mkdir($dir,0777,true);
  }
  $stmt = $pdo->prepare('SELECT id,file_path,file_name FROM module_projects_files WHERE project_id=:pid AND (folder_id IS NULL OR file_path NOT LIKE :p)');
  $stmt->execute([':pid'=>$pid, ':p'=>'/module/project/uploads/'.$pid.'/%']);
  $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach($files as $f){
    $basename = basename($f['file_path']);
    $oldFull = __DIR__ . '/uploads/' . $basename;
    $newRel = '/module/project/uploads/' . $pid . '/' . $basename;
    $newFull = __DIR__ . '/uploads/' . $pid . '/' . $basename;
    if(is_file($oldFull)){
      rename($oldFull,$newFull);
    }
    $pdo->prepare('UPDATE module_projects_files SET folder_id=:fid,file_path=:path WHERE id=:id')->execute([
      ':fid'=>$root,
      ':path'=>$newRel,
      ':id'=>$f['id']
    ]);
  }
}

echo "Migration complete\n";

