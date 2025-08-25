<?php
if (!isset($pdo)) {
  require '../includes/php_header.php';
}
header('Content-Type: application/json');
$scope = $_GET['scope'] ?? 'shared';
$currentDate = date('Y-m-d');
if ($scope === 'mine') {
  $events = [
    ['id' => 'm1', 'title' => 'My Task', 'start' => $currentDate . 'T09:00:00', 'link_module' => 'task', 'link_record_id' => 1],
    ['id' => 'm2', 'title' => 'Personal Event', 'start' => date('Y-m-d', strtotime('+2 days')) . 'T13:00:00', 'link_module' => 'meeting', 'link_record_id' => 2]
  ];
} else {
  $events = [
    ['id' => 's1', 'title' => 'Team Meeting', 'start' => date('Y-m-d', strtotime('+1 day')) . 'T10:00:00', 'link_module' => 'meeting', 'link_record_id' => 10],
    ['id' => 's2', 'title' => 'Deadline', 'start' => date('Y-m-d', strtotime('+3 days')), 'link_module' => 'project', 'link_record_id' => 20]
  ];
}
echo json_encode($events);
