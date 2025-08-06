<?php require '../../includes/php_header.php'; ?>
<?php require '../../includes/html_header.php'; ?>

<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>

  <div id="main_content" class="content">
    <?php
    $action = $_GET['action'] ?? 'home';
    $action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);
    $file = __DIR__ . "/include/{$action}.php";
    if (file_exists($file)) {
        require $file;
    } else {
        echo '<p>Requested page not found.</p>';
    }
    ?>

    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>

<?php require '../../includes/js_footer.php'; ?>
