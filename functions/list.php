<?php
if (!isset($pdo)) {
  require '../includes/php_header.php';
}
header('Content-Type: application/json');
$scope = $_GET['scope'] ?? 'shared';
$currentDate = date('Y-m-d');
if ($scope === 'mine') {
  $events = [
    ['id' => 'm1', 'title' => 'My Task', 'start' => $currentDate . 'T09:00:00'],
    ['id' => 'm2', 'title' => 'Personal Event', 'start' => date('Y-m-d', strtotime('+2 days')) . 'T13:00:00']
  ];
} else {
  $events = [
    ['id' => 's1', 'title' => 'Team Meeting', 'start' => date('Y-m-d', strtotime('+1 day')) . 'T10:00:00'],
    ['id' => 's2', 'title' => 'Deadline', 'start' => date('Y-m-d', strtotime('+3 days'))]
  ];
}
echo json_encode($events);
