<?php
require '../../includes/php_header.php';

$timezoneItems = get_lookup_items($pdo, 'TIMEZONE');
$userTimezoneId = get_user_default_lookup_item($pdo, $this_user_id, 'TIMEZONE');

$action = $_GET['action'] ?? '';
if ($action === 'create') {
    require_permission('calendar', 'create');
} elseif ($action === 'manage') {
    require_permission('calendar', 'read');
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
      } elseif ($action === 'manage') {
          require 'include/manage.php';
      } else {
          require 'include/calendar_view.php';
      }
      require '../../includes/html_footer.php';
    ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
