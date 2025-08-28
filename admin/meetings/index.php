<?php
require '../admin_header.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'edit':
    require_permission('meeting', 'update');
    $id = (int)($_GET['id'] ?? 0);
    $meeting = [];
    if ($id) {
      $stmt = $pdo->prepare('SELECT m.id, m.title, m.description, m.start_time, m.end_time, m.recur_daily, m.recur_weekly, m.recur_monthly, m.calendar_event_id, ce.title AS calendar_event_title, m.status_id, m.type_id FROM module_meetings m LEFT JOIN module_calendar_events ce ON m.calendar_event_id = ce.id WHERE m.id = ?');
      $stmt->execute([$id]);
      $meeting = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    require 'include/create_edit_view.php';
    require '../admin_footer.php';
    break;
  case 'details':
    require_permission('meeting', 'read');
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT m.id, m.title, m.description, m.start_time, m.end_time, m.recur_daily, m.recur_weekly, m.recur_monthly, m.calendar_event_id, ce.title AS calendar_event_title, m.status_id, m.type_id FROM module_meetings m LEFT JOIN module_calendar_events ce ON m.calendar_event_id = ce.id WHERE m.id = ?');
    $stmt->execute([$id]);
    $meeting = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    require 'include/details_view.php';
    require '../admin_footer.php';
    break;
  default:
    require_permission('meeting', 'read');
    $meetings = $pdo->query('SELECT id, title, start_time FROM module_meetings ORDER BY start_time DESC')->fetchAll(PDO::FETCH_ASSOC);
    require 'include/list_view.php';
    require '../admin_footer.php';
    break;
}
