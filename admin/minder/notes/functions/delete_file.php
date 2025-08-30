<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('minder_note','update');

if (!verify_csrf_token($_GET['csrf_token'] ?? '')) { http_response_code(403); exit('Invalid CSRF token'); }
$id = (int)($_GET['id'] ?? 0);
$note_id = (int)($_GET['note_id'] ?? 0);
if (!$id || !$note_id) { http_response_code(400); exit('Missing data'); }
$stmt = $pdo->prepare('SELECT file_path FROM admin_minder_notes_files WHERE id=:id AND note_id=:nid');
$stmt->execute([':id'=>$id, ':nid'=>$note_id]);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
if ($file) {
  $path = dirname(__DIR__,4) . '/' . $file['file_path'];
  if (is_file($path)) { @unlink($path); }
  $pdo->prepare('DELETE FROM admin_minder_notes_files WHERE id=:id')->execute([':id'=>$id]);
  admin_audit_log($pdo,$this_user_id,'admin_minder_notes_files',$id,'DELETE',json_encode($file),null);
}
header('Location: ../note.php?id=' . $note_id);
exit;
?>
