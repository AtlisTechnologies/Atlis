<?php
require '../../includes/php_header.php';
require_permission('agency','read');

$action = $_GET['action'] ?? 'card';

// Fetch agencies and attach status info
$statusMap = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$stmt = $pdo->query('SELECT id, name, status FROM module_agency ORDER BY name');
$agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($agencies as &$agency) {
  $status = $statusMap[$agency['status']] ?? null;
  $agency['status_label'] = $status['label'] ?? null;
  $agency['status_color'] = $status['color_class'] ?? 'secondary';
}
unset($agency);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php // require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <nav class="nav nav-pills mb-3">
      <a class="nav-link <?php echo $action === 'card' ? 'active' : ''; ?>" href="?action=card">Card view</a>
      <a class="nav-link <?php echo $action === 'list' ? 'active' : ''; ?>" href="?action=list">List view</a>
      <a class="nav-link <?php echo $action === 'board' ? 'active' : ''; ?>" href="?action=board">Board view</a>
    </nav>
    <?php
      if ($action === 'list') {
        require 'include/list_view.php';
      } elseif ($action === 'board') {
        require 'include/board_view.php';
      } else {
        require 'include/card_view.php';
      }
    ?>
    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
