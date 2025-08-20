<?php
require '../../includes/php_header.php';
$action = $_GET['action'] ?? 'list';
require_permission('kanban', $action);
require_once __DIR__.'/functions/kanban_crud.php';

if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = $_POST['id'] ?? null;
    $name = trim($_POST['name'] ?? '');
    save_board($pdo, $id ? (int)$id : null, $name, $this_user_id);
    header('Location: index.php');
    exit;
}

if ($action === 'delete' && isset($_GET['id'])) {
    delete_board($pdo, (int)$_GET['id']);
    header('Location: index.php');
    exit;
}

$board = null;
$boards = [];
$statuses = [];

if ($action === 'list') {
    $boards = fetch_boards($pdo);
} elseif ($action === 'edit' || $action === 'board') {
    $board_id = (int)($_GET['id'] ?? 0);
    $board = fetch_board($pdo, $board_id);
    $statuses = fetch_statuses($pdo, $board_id);
}

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php
      $viewMap = [
        'list' => 'list_view.php',
        'board' => 'board_view.php',
        'create' => 'form.php',
        'edit' => 'form.php'
      ];
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
