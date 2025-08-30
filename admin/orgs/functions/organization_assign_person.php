<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$organization_id = (int)($_POST['organization_id'] ?? 0);
$person_id      = (int)($_POST['person_id'] ?? 0);
$role_id        = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;
$is_lead        = isset($_POST['is_lead']) ? 1 : 0;
$token          = $_POST['csrf_token'] ?? '';

require_permission('organization','update');

if ($token !== ($_SESSION['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

if ($organization_id && $person_id) {
  if ($is_lead) {
    $stmt = $pdo->prepare('UPDATE module_organization_persons SET is_lead=0 WHERE organization_id=:id');
    $stmt->execute([':id' => $organization_id]);
  }
  $stmt = $pdo->prepare('INSERT INTO module_organization_persons (user_id,user_updated,organization_id,person_id,role_id,is_lead) VALUES (:uid,:uid,:org,:pid,:role,:lead)');
  $stmt->execute([':uid' => $this_user_id, ':org' => $organization_id, ':pid' => $person_id, ':role' => $role_id, ':lead' => $is_lead]);
  $assignId = $pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_organization_persons', $assignId, 'CREATE', null, json_encode(['organization_id' => $organization_id, 'person_id' => $person_id, 'role_id' => $role_id, 'is_lead' => $is_lead]), 'Assigned person');

  $infoStmt = $pdo->prepare('SELECT CONCAT(p.first_name," ",p.last_name) AS name, li.label AS role_label FROM person p LEFT JOIN lookup_list_items li ON li.id = :rid WHERE p.id = :pid');
  $infoStmt->execute([':rid' => $role_id, ':pid' => $person_id]);
  $info = $infoStmt->fetch(PDO::FETCH_ASSOC);

  $row = '<tr><td>' . e($info['name'] ?? '') . '</td><td>' . e($info['role_label'] ?? '') . '</td><td>' . ($is_lead ? 'Yes' : 'No') . '</td><td><button class="btn btn-sm btn-danger remove-person" data-url="functions/organization_remove_person.php" data-assignment-id="' . $assignId . '" data-csrf="' . e($token) . '">Remove</button></td></tr>';

  echo json_encode(['success' => true, 'row' => $row]);
  exit;
}

echo json_encode(['success' => false]);
