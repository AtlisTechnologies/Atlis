<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'shared';

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $is_private = !empty($_POST['is_private']) ? 1 : 0;
    if ($name !== '') {
        $stmt = $pdo->prepare('INSERT INTO module_calendars (user_id, name, is_private) VALUES (?,?,?)');
        $stmt->execute([$this_user_id, $name, $is_private]);
        header('Location: index.php?action=my');
        exit;
    }
}

if ($action === 'my') {
    $stmt = $pdo->prepare('SELECT e.title,e.start_time,e.end_time FROM module_calendar_events e JOIN module_calendars c ON e.calendar_id=c.id WHERE c.user_id = :uid');
    $stmt->execute([':uid' => $this_user_id]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query('SELECT e.title,e.start_time,e.end_time FROM module_calendar_events e JOIN module_calendars c ON e.calendar_id=c.id WHERE c.is_private = 0');
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
