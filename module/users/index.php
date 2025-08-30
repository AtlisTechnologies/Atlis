<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? '';

if ($action === 'logout') {
  require 'functions/logout.php';
  require '../../includes/html_header.php';
  require 'include/logout.php';
  require '../../includes/js_footer.php';
  exit;
}

if ($is_logged_in && in_array($action, ['login', '2fa'])) {
  header('Location: ' . getURLDir());
  exit;
}

if (!$is_logged_in && !in_array($action, ['login', '2fa'])) {
  header('Location: ' . getURLDir() . 'module/users/index.php?action=login');
  exit;
}

if ($action === 'login') {
  require '../../includes/html_header.php';
  require 'include/login.php';
  require '../../includes/js_footer.php';
  exit;
}

if ($action === '2fa') {
  require '../../includes/html_header.php';
  require 'include/2fa.php';
  require '../../includes/js_footer.php';
  exit;
}

if ($action === 'save-settings' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require 'functions/save_settings.php';
  exit;
}

if ($action === 'settings') {
  $timezoneItems       = get_lookup_items($pdo, 'TIMEZONE');
  $projectStatusItems   = get_lookup_items($pdo, 'PROJECT_STATUS');
  $projectPriorityItems = get_lookup_items($pdo, 'PROJECT_PRIORITY');
  $projectTypeItems     = get_lookup_items($pdo, 'PROJECT_TYPE');
  $taskStatusItems      = get_lookup_items($pdo, 'TASK_STATUS');
  $taskPriorityItems    = get_lookup_items($pdo, 'TASK_PRIORITY');
  $calendarEventTypeItems = get_lookup_items($pdo, 'CALENDAR_EVENT_TYPE');

  $agencies = $pdo->query('SELECT id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
  $divisions = $pdo->query('SELECT id, name, agency_id FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

  $userCalendars = $pdo->prepare('SELECT id, name, is_private FROM module_calendar WHERE user_id = :uid');
  $userCalendars->execute([':uid' => $this_user_id]);
  $userCalendars = $userCalendars->fetchAll(PDO::FETCH_ASSOC);

  $userDefaults = [
    'PROJECT_STATUS'   => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_STATUS'),
    'PROJECT_PRIORITY' => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_PRIORITY'),
    'PROJECT_TYPE'     => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_TYPE'),
    'PROJECT_AGENCY'   => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_AGENCY'),
    'PROJECT_DIVISION' => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_DIVISION'),
    'TASK_STATUS'      => get_user_default_lookup_item($pdo, $this_user_id, 'TASK_STATUS'),
    'TASK_PRIORITY'    => get_user_default_lookup_item($pdo, $this_user_id, 'TASK_PRIORITY'),
    'CALENDAR_DEFAULT' => get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_DEFAULT'),
    'CALENDAR_EVENT_TYPE_DEFAULT' => get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_EVENT_TYPE_DEFAULT'),
  ];

  $tzStmt = $pdo->prepare('SELECT timezone_id FROM users WHERE id = :uid');
  $tzStmt->execute([':uid' => $this_user_id]);
  $userTimezoneId = $tzStmt->fetchColumn();

  require '../../includes/html_header.php';
  ?>
  <main class="main" id="top">
    <?php require "../../includes/left_navigation.php"; ?>
    <?php require "../../includes/navigation.php"; ?>
    <div id="main_content" class="content">
      <?php require 'include/settings.php'; ?>
      <?php require '../../includes/html_footer.php'; ?>
    </div>
  </main>
  <?php require '../../includes/js_footer.php'; ?>
  <?php
  exit;
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require "../../includes/left_navigation.php"; ?>
  <?php require "../../includes/navigation.php"; ?>
  <div id="main_content" class="content">
    <?php require 'include/home.php'; ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
