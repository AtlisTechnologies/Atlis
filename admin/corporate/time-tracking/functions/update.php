<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
require_once __DIR__ . '/../../../../includes/php_header.php';
require_permission('admin_time_tracking','update');
header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$memo = trim($_POST['memo'] ?? '');
$hours = $_POST['hours'] ?? null;
$invoice_id = $_POST['invoice_id'] ?? null;
$person_id = $_POST['person_id'] ?? null;
$work_date = $_POST['work_date'] ?? null;
$rate = $_POST['rate'] ?? null;

if (!$id || $memo === '' || $hours === null || !$person_id || !$work_date) {
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

$stmt = $pdo->prepare('UPDATE admin_time_tracking_entries SET memo = :memo, person_id = :person_id, work_date = :work_date, hours = :hours, rate = :rate, invoice_id = :invoice_id, user_updated = :uid WHERE id = :id');
$stmt->execute([
  ':memo' => $memo,
  ':person_id' => $person_id,
  ':work_date' => $work_date,
  ':hours' => $hours,
  ':rate' => $rate,
  ':invoice_id' => $invoice_id ?: null,
  ':uid' => $this_user_id,
  ':id' => $id
]);

echo json_encode(['success' => true]);
