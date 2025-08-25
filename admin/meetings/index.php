<?php
require '../admin_header.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'create':
  case 'edit':
    $perm = ($action === 'create') ? 'create' : 'update';
    require_permission('meeting', $perm);
    $id = (int)($_GET['id'] ?? 0);
    $meeting = [];
    if ($action === 'edit' && $id) {
      $stmt = $pdo->prepare('SELECT id, title, description, start_time, end_time, recur_daily, recur_weekly, recur_monthly FROM module_meetings WHERE id = ?');
      $stmt->execute([$id]);
      $meeting = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    require 'include/create_edit_view.php';
    require '../admin_footer.php';
    break;
  case 'details':
    require_permission('meeting', 'read');
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT id, title, description, start_time, end_time, recur_daily, recur_weekly, recur_monthly FROM module_meetings WHERE id = ?');
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
