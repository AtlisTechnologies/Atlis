<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? '';

if ($action === 'logout') {
  require 'functions/logout.php';
  exit;
}

if ($is_logged_in && $action === 'login') {
  header('Location: ' . getURLDir());
  exit;
}

if (!$is_logged_in && $action !== 'login') {
  header('Location: index.php?action=login');
  exit;
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require "../../includes/left_navigation.php"; ?>
  <?php require "../../includes/navigation.php"; ?>
  <div id="main_content" class="content">
    <?php
    if ($action === 'login') {
      require 'include/login.php';
    }
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
