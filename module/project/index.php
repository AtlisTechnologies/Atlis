<?php
require '../../includes/php_header.php';
require_permission('project','read');

$action = $_GET['action'] ?? 'card';

$statusMap = array_column(get_lookup_items($pdo, 'PROJECT_STATUS'), null, 'id');
$stmt = $pdo->query('SELECT id, name, status FROM module_projects ORDER BY name');
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($projects as &$project) {
  $status = $statusMap[$project['status']] ?? null;
  $project['status_label'] = $status['label'] ?? null;
  $project['status_color'] = $status['color_class'] ?? 'secondary';
}
unset($project);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <?php require 'include/card_view.php'; ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
