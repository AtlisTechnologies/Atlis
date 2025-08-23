<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
  case 'create':
  case 'edit':
    $perm = ($action === 'create') ? 'create' : 'update';
    require_permission('meeting', $perm);
    $id = (int)($_GET['id'] ?? 0);
    $meeting = [];
    if ($action === 'edit' && $id) {
      $stmt = $pdo->prepare('SELECT * FROM module_meeting WHERE id = ?');
      $stmt->execute([$id]);
      $meeting = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php // require '../../includes/left_navigation.php'; ?>
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/create_edit_view.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    exit;
  case 'details':
    require_permission('meeting', 'read');
    $id = (int)($_GET['id'] ?? 0);
    $stmt = $pdo->prepare('SELECT * FROM module_meeting WHERE id = ?');
    $stmt->execute([$id]);
    $meeting = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/details_view.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    exit;
  default:
    require_permission('meeting', 'read');
    $meetings = $pdo->query('SELECT * FROM module_meeting ORDER BY date_created DESC')->fetchAll(PDO::FETCH_ASSOC);
    require '../../includes/html_header.php';
    ?>
    <main class="main" id="top">
      <?php require '../../includes/navigation.php'; ?>
      <div id="main_content" class="content">
        <?php require 'include/list_view.php'; ?>
        <?php require '../../includes/html_footer.php'; ?>
      </div>
    </main>
    <?php require '../../includes/js_footer.php'; ?>
    <?php
    exit;
}
