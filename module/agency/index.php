<?php
require '../../includes/php_header.php';
require_permission('agency','read');

$action = $_GET['action'] ?? 'card';

$filters = [
  'name'   => trim($_GET['name'] ?? ''),
  'status' => $_GET['status'] ?? '',
  'lead'   => $_GET['lead'] ?? '',
  'org'    => $_GET['org'] ?? ''
];
$queryFilters = array_filter($filters, fn($v) => $v !== '');
$filterQuery = http_build_query($queryFilters);

// Fetch agencies and status lookup
$statusList = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$statusList[0] = ['label' => 'Unassigned', 'color_class' => 'secondary'];

// Lead users for filter select
$leadUsers = $pdo->query("SELECT u.id, COALESCE(CONCAT(p.first_name,' ',p.last_name), u.email) AS name
                           FROM users u
                           LEFT JOIN person p ON u.id = p.user_id
                           ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

// Organizations for filter select
$organizations = $pdo->query("SELECT id, name FROM module_organization ORDER BY name")
                      ->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT a.id, a.name, a.status, a.file_name, a.file_path, a.file_type,
               o.name AS organization_name,
               COUNT(DISTINCT aa.assigned_user_id) AS user_count,
               (SELECT COUNT(*) FROM person p WHERE p.agency_id = a.id) AS person_count
        FROM module_agency a
        LEFT JOIN module_agency_assignments aa ON a.id = aa.agency_id
        LEFT JOIN module_organization o ON a.organization_id = o.id";
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
if ($filters['org'] !== '') {
  $conditions[] = "a.organization_id = :org";
  $params[':org'] = $filters['org'];
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
    <div class="card mb-3">
      <div class="card-body">
        <form method="get" class="row g-2">
          <input type="hidden" name="action" value="<?= h($action); ?>">
          <div class="col-sm-3">
            <input class="form-control" type="text" name="name" placeholder="Search name" value="<?= h($filters['name']); ?>">
          </div>
          <div class="col-sm-2">
            <select class="form-select" name="status">
              <option value="">All Statuses</option>
              <?php foreach ($statusList as $id => $status): ?>
                <option value="<?= $id ?>" <?= $filters['status']==$id ? 'selected' : '' ?>><?= h($status['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-3">
            <select class="form-select" name="org">
              <option value="">All Organizations</option>
              <?php foreach ($organizations as $org): ?>
                <option value="<?= $org['id']; ?>" <?= $filters['org']==$org['id'] ? 'selected' : '' ?>><?= h($org['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-2">
            <select class="form-select" name="lead">
              <option value="">All Leads</option>
              <?php foreach ($leadUsers as $user): ?>
                <option value="<?= $user['id']; ?>" <?= $filters['lead']==$user['id'] ? 'selected' : '' ?>><?= h($user['name']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-sm-2">
            <button class="btn btn-primary w-100" type="submit">Filter</button>
          </div>
        </form>
      </div>
    </div>
    <nav class="nav nav-pills mb-3">
      <a class="nav-link <?= $action === 'card' ? 'active' : ''; ?>" href="?<?= http_build_query(array_merge(['action' => 'card'], $queryFilters)); ?>">Card view</a>
      <a class="nav-link <?= $action === 'list' ? 'active' : ''; ?>" href="?<?= http_build_query(array_merge(['action' => 'list'], $queryFilters)); ?>">List view</a>
      <a class="nav-link <?= $action === 'board' ? 'active' : ''; ?>" href="?<?= http_build_query(array_merge(['action' => 'board'], $queryFilters)); ?>">Board view</a>
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
<?php $loadFsLightbox = true; require '../../includes/js_footer.php'; ?>
