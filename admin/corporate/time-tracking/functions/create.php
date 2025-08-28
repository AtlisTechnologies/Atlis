<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','create');
header('Content-Type: application/json');

$memo = trim($_POST['memo'] ?? '');
$hours = $_POST['hours'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;
$person_id = $_POST['person_id'] ?? null;
$project_id = $_POST['project_id'] ?? null;
$work_date = $_POST['work_date'] ?? null;
$rate = $_POST['rate'] ?? null;
$corporate_id = $_POST['corporate_id'] ?? 1;

if ($memo === '' || $hours === null || !$person_id || !$work_date) {
  echo json_encode(['success' => false, 'error' => 'Missing fields']);
  exit;
}

$stmt = $pdo->prepare('INSERT INTO admin_time_tracking_entries (user_id, corporate_id, person_id, project_id, work_date, hours, rate, invoice_id, memo) VALUES (:uid, :cid, :person_id, :project_id, :work_date, :hours, :rate, :invoice_id, :memo)');
$stmt->execute([
  ':uid' => $this_user_id,
  ':cid' => $corporate_id,
  ':person_id' => $person_id,
  ':project_id' => $project_id ?: null,
  ':work_date' => $work_date,
  ':hours' => $hours,
  ':rate' => $rate,
  ':invoice_id' => $invoice_id ?: null,
  ':memo' => $memo
]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
