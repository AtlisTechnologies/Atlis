<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../includes/php_header.php';
require_permission('minder_note','delete');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['error_message'] = 'Method not allowed';
  header('Location: ../index.php');
  exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
  $_SESSION['error_message'] = 'Invalid CSRF token';
  header('Location: ../index.php');
  exit;
}

$id = (int)($_POST['id'] ?? 0);
if ($id <= 0) {
  $_SESSION['error_message'] = 'Invalid ID';
  header('Location: ../index.php');
  exit;
}

try {
  $fileStmt = $pdo->prepare('SELECT file_path FROM admin_minder_note_file WHERE note_id = :id');
  $fileStmt->execute([':id' => $id]);
  $paths = $fileStmt->fetchAll(PDO::FETCH_COLUMN);
  foreach ($paths as $p) {
    $full = __DIR__ . '/../uploads/' . basename($p);
    if (is_file($full)) {
      @unlink($full);
    }
  }
  $pdo->prepare('DELETE FROM admin_minder_note WHERE id = :id')->execute([':id' => $id]);
} catch (PDOException $e) {
  $_SESSION['error_message'] = 'Delete failed';
  header('Location: ../index.php');
  exit;
}

admin_audit_log($pdo, $this_user_id, 'minder_note', $id, 'DELETE', null, null, 'Deleted note');

$_SESSION['message'] = 'Note deleted';
header('Location: ../index.php');
exit;
