<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'shared';

// Load events only when viewing existing calendars
$events = [];
if ($action === 'my') {
    $stmt = $pdo->prepare('SELECT e.title,e.start_time,e.end_time FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id=c.id WHERE c.user_id = :uid');
    $stmt->execute([':uid' => $this_user_id]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($action === 'shared') {
    $stmt = $pdo->query('SELECT e.title,e.start_time,e.end_time FROM module_calendar_events e JOIN module_calendar c ON e.calendar_id=c.id WHERE c.is_private = 0');
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($action === 'create') {
    require_permission('calendar','create');
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php
      if ($action === 'create') {
          require 'include/create_form.php';
      } else {
          require 'include/calendar_view.php';
      }
      require '../../includes/html_footer.php';
    ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
