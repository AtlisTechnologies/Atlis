<?php
require '../../includes/php_header.php';
require_permission('agency','read');

$action = $_GET['action'] ?? 'card';

$filters = [
  'name'   => trim($_GET['name'] ?? ''),
  'status' => $_GET['status'] ?? '',
  'lead'   => $_GET['lead'] ?? ''
];

// Fetch agencies and status lookup
$statusList = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$statusList[0] = ['label' => 'Unassigned', 'color_class' => 'secondary'];

// Lead users for filter select
$leadUsers = $pdo->query("SELECT u.id, COALESCE(CONCAT(p.first_name,' ',p.last_name), u.email) AS name
                           FROM users u
                           LEFT JOIN person p ON u.id = p.user_id
                           ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT a.id, a.name, a.status,
               COUNT(DISTINCT aa.assigned_user_id) AS user_count,
               (SELECT COUNT(*) FROM person p WHERE p.agency_id = a.id) AS person_count
        FROM module_agency a
        LEFT JOIN module_agency_assignments aa ON a.id = aa.agency_id";
$conditions = [];
$params = [];
if ($filters['name'] !== '') {
  $conditions[] = "a.name LIKE :name";
  $params[':name'] = '%' . $filters['name'] . '%';
}
if ($filters['status'] !== '') {
  $conditions[] = "a.status = :status";
  $params[':status'] = $filters['status'];
}
if ($filters['lead'] !== '') {
  $conditions[] = "aa.assigned_user_id = :lead";
  $params[':lead'] = $filters['lead'];
}
if ($conditions) {
  $sql .= ' WHERE ' . implode(' AND ', $conditions);
}
$sql .= ' GROUP BY a.id ORDER BY a.name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
