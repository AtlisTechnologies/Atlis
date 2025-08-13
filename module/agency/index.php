<?php
require '../../includes/php_header.php';
require_permission('agency','read');

$action = get_get('action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'card';

// Fetch agencies and status labels
$sql = "SELECT a.id, a.name, li.label AS status_label
        FROM module_agency a
        LEFT JOIN lookup_list_items li ON a.status = li.id AND li.active_from <= CURDATE() AND (li.active_to IS NULL OR li.active_to >= CURDATE())
        LEFT JOIN lookup_lists l ON li.list_id = l.id AND l.name = 'AGENCY_STATUS'
        ORDER BY a.name";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
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
