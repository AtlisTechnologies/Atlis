<?php
require '../admin_header.php';
require_permission('orgs','read');

$view = $_GET['view'] ?? ($_SESSION['orgs_view'] ?? 'tree');
$_SESSION['orgs_view'] = $view;

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($view === 'list') {
    // Flat searchable list of organizations
    $orgStmt = $pdo->query('SELECT o.id, c.name FROM module_organization o JOIN module_customer c ON o.customer_id = c.id ORDER BY c.name');
    $organizations = $orgStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Hierarchical view data
    $orgStmt = $pdo->query('SELECT o.id, c.name FROM module_organization o JOIN module_customer c ON o.customer_id = c.id ORDER BY c.name');
    $organizations = $orgStmt->fetchAll(PDO::FETCH_ASSOC);

    $agencyRows = $pdo->query('SELECT a.id, a.organization_id, c.name FROM module_agency a JOIN module_customer c ON a.customer_id = c.id ORDER BY c.name')->fetchAll(PDO::FETCH_ASSOC);
    $agencies = [];
    foreach ($agencyRows as $row) {
        $agencies[$row['organization_id']][] = $row;
    }

    $divisionRows = $pdo->query('SELECT d.id, d.agency_id, c.name FROM module_division d JOIN module_customer c ON d.customer_id = c.id ORDER BY c.name')->fetchAll(PDO::FETCH_ASSOC);
    $divisions = [];
    foreach ($divisionRows as $row) {
        $divisions[$row['agency_id']][] = $row;
    }
}
?>
<h2 class="mb-4">Organizations</h2>
<div class="mb-3">
  <a href="organization.php" class="btn btn-sm btn-success">Add Organization</a>
  <a href="?view=<?= $view === 'tree' ? 'list' : 'tree'; ?>" class="btn btn-sm btn-outline-primary ms-2">Switch to <?= $view === 'tree' ? 'Search' : 'Hierarchy'; ?> View</a>
</div>
<?php if ($view === 'list'): ?>
  <div id="organizations" data-list='{"valueNames":["id","name"],"page":10,"pagination":true}'>
    <div class="row justify-content-between g-2 mb-3">
      <div class="col-auto">
        <input class="form-control form-control-sm search" placeholder="Search" />
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm mb-0">
        <thead>
          <tr>
            <th class="sort" data-sort="id">ID</th>
            <th class="sort" data-sort="name">Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="list">
          <?php foreach($organizations as $o): ?>
            <tr>
              <td class="id"><?= htmlspecialchars($o['id']); ?></td>
              <td class="name"><?= htmlspecialchars($o['name']); ?></td>
              <td>
                <a class="btn btn-sm btn-warning" href="organization.php?id=<?= $o['id']; ?>">Edit</a>
                <a class="btn btn-sm btn-info" href="agency.php?organization_id=<?= $o['id']; ?>">Agencies</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-3">
      <p class="mb-0" data-list-info></p>
      <ul class="pagination mb-0"></ul>
    </div>
  </div>
<?php else: ?>
  <?php foreach ($organizations as $org): ?>
    <div class="card mb-3">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><?= htmlspecialchars($org['name']); ?></h5>
        <div>
          <a class="btn btn-sm btn-secondary" href="organization.php?id=<?= $org['id']; ?>">View</a>
        </div>
      </div>
      <div class="card-body">
        <h6>Agencies</h6>
        <?php if (!empty($agencies[$org['id']])): ?>
          <ul class="list-unstyled ms-3">
            <?php foreach ($agencies[$org['id']] as $agency): ?>
              <li class="mb-2">
                <strong><a href="agency.php?id=<?= $agency['id']; ?>"><?= htmlspecialchars($agency['name']); ?></a></strong>
                <?php if (!empty($divisions[$agency['id']])): ?>
                  <ul class="list-unstyled ms-3 mt-1">
                    <?php foreach ($divisions[$agency['id']] as $division): ?>
                      <li><a href="division.php?id=<?= $division['id']; ?>"><?= htmlspecialchars($division['name']); ?></a></li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
                <a class="btn btn-sm btn-success mt-1" href="division.php?agency_id=<?= $agency['id']; ?>">Add Division</a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="ms-3 text-muted">No agencies yet.</p>
        <?php endif; ?>
        <a class="btn btn-sm btn-success" href="agency.php?organization_id=<?= $org['id']; ?>">Add Agency</a>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
