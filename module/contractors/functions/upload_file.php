<?php
require '../../../includes/php_header.php';
require_role('contractor_admin','contractor_manager');

$uploadDir = CONTRACTOR_UPLOAD_DIR;
if (!is_dir($uploadDir)) {
  mkdir($uploadDir, 0777, true);
}

$file = $_FILES['file'] ?? null;
if ($file && $file['error'] === UPLOAD_ERR_OK && $file['size'] <= CONTRACTOR_MAX_FILE_SIZE) {
  $targetName = uniqid('contractor_', true) . '_' . preg_replace('/[^A-Za-z0-9\.\-_]/', '', $file['name']);
  $targetPath = $uploadDir . $targetName;
  if (move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['success' => true, 'file' => $targetName]);
    exit;
  }
}

echo json_encode(['success' => false]);
