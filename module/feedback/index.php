<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'create':
    require_permission('feedback', 'create');
    $types = get_lookup_items($pdo, 'FEEDBACK_TYPE');
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php // require '../../includes/left_navigation.php'; ?>
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/form.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    break;

  case 'edit':
    require_permission('feedback', 'save');
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT id, title, description, type FROM module_feedback WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $feedbackItem = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $types = get_lookup_items($pdo, 'FEEDBACK_TYPE');
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php // require '../../includes/left_navigation.php'; ?>
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/form.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    break;

  case 'save':
    require_permission('feedback', 'save');
    require 'functions/create.php';
    break;

  case 'update':
    require_permission('feedback', 'save');
    require 'functions/update.php';
    break;

  case 'details':
    require_permission('feedback', 'details');
    $types = get_lookup_items($pdo, 'FEEDBACK_TYPE');
    $typeMap = array_column($types, null, 'id');
    require 'functions/details.php';
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php // require '../../includes/left_navigation.php'; ?>
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/details_view.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    break;

  case 'list':
  default:
    require_permission('feedback', 'list');
    $types = get_lookup_items($pdo, 'FEEDBACK_TYPE');
    $typeMap = array_column($types, null, 'id');
    require 'functions/list.php';
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php // require '../../includes/left_navigation.php'; ?>
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/list_view.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    break;
}
