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
  $projectStatusItems   = get_lookup_items($pdo, 'PROJECT_STATUS');
  $projectPriorityItems = get_lookup_items($pdo, 'PROJECT_PRIORITY');
  $projectTypeItems     = get_lookup_items($pdo, 'PROJECT_TYPE');
  $taskStatusItems      = get_lookup_items($pdo, 'TASK_STATUS');
  $taskPriorityItems    = get_lookup_items($pdo, 'TASK_PRIORITY');

  $userDefaults = [
    'PROJECT_STATUS'   => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_STATUS'),
    'PROJECT_PRIORITY' => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_PRIORITY'),
    'PROJECT_TYPE'     => get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_TYPE'),
    'TASK_STATUS'      => get_user_default_lookup_item($pdo, $this_user_id, 'TASK_STATUS'),
    'TASK_PRIORITY'    => get_user_default_lookup_item($pdo, $this_user_id, 'TASK_PRIORITY'),
  ];

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
