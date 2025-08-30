<?php
require '../../../includes/php_header.php';
header('Content-Type: application/json');

$agency_id = (int)($_POST['agency_id'] ?? 0);
$person_id = (int)($_POST['person_id'] ?? 0);
$role_id   = $_POST['role_id'] !== '' ? (int)$_POST['role_id'] : null;
$is_lead   = isset($_POST['is_lead']) ? 1 : 0;
$token     = $_POST['csrf_token'] ?? '';

require_permission('agency', 'update');

if ($token !== ($_SESSION['csrf_token'] ?? '')) {
  echo json_encode(['success' => false, 'error' => 'Invalid CSRF token']);
  exit;
}

if ($agency_id && $person_id) {
  if ($is_lead) {
    $pdo->prepare('UPDATE module_agency_persons SET is_lead=0 WHERE agency_id=:id')->execute([':id' => $agency_id]);
  }
  $stmt = $pdo->prepare('INSERT INTO module_agency_persons (user_id,user_updated,agency_id,person_id,role_id,is_lead) VALUES (:uid,:uid,:aid,:pid,:role,:lead)');
  $stmt->execute([':uid' => $this_user_id, ':aid' => $agency_id, ':pid' => $person_id, ':role' => $role_id, ':lead' => $is_lead]);
  $assignId = $pdo->lastInsertId();
  admin_audit_log($pdo, $this_user_id, 'module_agency_persons', $assignId, 'CREATE', null, json_encode(['agency_id' => $agency_id, 'person_id' => $person_id, 'role_id' => $role_id, 'is_lead' => $is_lead]), 'Assigned person');

  $infoStmt = $pdo->prepare('SELECT CONCAT(p.first_name," ",p.last_name) AS name, li.label AS role_label FROM person p LEFT JOIN lookup_list_items li ON li.id = :rid WHERE p.id = :pid');
  $infoStmt->execute([':rid' => $role_id, ':pid' => $person_id]);
  $info = $infoStmt->fetch(PDO::FETCH_ASSOC);

  $row = '<tr><td>' . e($info['name'] ?? '') . '</td><td>' . e($info['role_label'] ?? '') . '</td><td>' . ($is_lead ? 'Yes' : 'No') . '</td><td><button class="btn btn-sm btn-danger remove-person" data-url="functions/agency_remove_person.php" data-assignment-id="' . $assignId . '" data-csrf="' . e($token) . '">Remove</button></td></tr>';

  echo json_encode(['success' => true, 'row' => $row]);
  exit;
}

echo json_encode(['success' => false]);
