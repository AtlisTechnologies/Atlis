<?php
require '../../../includes/admin_guard.php';
require_permission('admin_corporate_files','read');

$id = (int)($_GET['id'] ?? 0);
if(!$id){
  http_response_code(400);
  exit('Invalid file id');
}

$stmt = $pdo->prepare('SELECT file_name,file_path,file_type FROM admin_corporate_files WHERE id = :id');
$stmt->execute([':id'=>$id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$file){
  http_response_code(404);
  exit('File not found');
}

$full = __DIR__ . '/../../' . $file['file_path'];
if(!file_exists($full)){
  http_response_code(404);
  exit('File not found');
}

admin_audit_log($pdo,$this_user_id,'admin_corporate_files',$id,'DOWNLOAD','',json_encode(['file'=>$file['file_name']]));

header('Content-Description: File Transfer');
header('Content-Type: ' . ($file['file_type'] ?: 'application/octet-stream'));
header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
header('Content-Length: ' . filesize($full));

readfile($full);
exit;
