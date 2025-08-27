<?php
require '../../includes/php_header.php';

$action = $_GET['action'] ?? 'list';

if ($action === 'delete') {
  require_permission('conference','delete');
  require 'functions/delete.php';
  exit;
}

if ($action === 'create-edit') {
  $id = (int)($_GET['id'] ?? 0);
  if ($id) {
    require_permission('conference','update');
    $stmt = $pdo->prepare('SELECT * FROM module_conferences WHERE id=?');
    $stmt->execute([$id]);
    $conference = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
  } else {
    require_permission('conference','create');
    $conference = [];
  }
} elseif ($action === 'details') {
  require_permission('conference','read');
  $id = (int)($_GET['id'] ?? 0);
  $stmt = $pdo->prepare('SELECT * FROM module_conferences WHERE id=?');
  $stmt->execute([$id]);
  $conference = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$conference) {
    http_response_code(404);
    exit;
  }
} else {
  require_permission('conference','read');
  $stmt = $pdo->query('SELECT id,title,schedule,venue FROM module_conferences ORDER BY schedule DESC');
  $conferences = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        'details' => 'details_view.php',
        'create-edit' => 'create_edit_view.php'
      ];
      $viewFile = $viewMap[$action] ?? 'list_view.php';
      require 'include/' . $viewFile;
      require '../../includes/html_footer.php';
    ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
