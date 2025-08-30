<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$assignment_id   = (int)($_POST['assignment_id'] ?? 0);
$organization_id = (int)($_POST['organization_id'] ?? 0);
$token           = $_POST['csrf_token'] ?? '';

require_permission('organization', 'update');

if ($token !== ($_SESSION['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

if ($assignment_id) {
  $stmt = $pdo->prepare('DELETE FROM module_organization_persons WHERE id=:id');
  $stmt->execute([':id' => $assignment_id]);
  admin_audit_log($pdo, $this_user_id, 'module_organization_persons', $assignment_id, 'DELETE', null, null, 'Removed person');
  echo json_encode(['success' => true]);
  exit;
}

echo json_encode(['success' => false]);
