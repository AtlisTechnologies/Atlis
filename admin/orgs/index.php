<?php
require '../admin_header.php';
require_permission('orgs','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

// Fetch organizations
$orgStmt = $pdo->query('SELECT id, name FROM module_organization ORDER BY name');
$organizations = $orgStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch agencies grouped by organization
$agencyRows = $pdo->query('SELECT id, organization_id, name FROM module_agency ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$agencies = [];
foreach ($agencyRows as $row) {
    $agencies[$row['organization_id']][] = $row;
}

// Fetch divisions grouped by agency
$divisionRows = $pdo->query('SELECT id, agency_id, name FROM module_division ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$divisions = [];
foreach ($divisionRows as $row) {
    $divisions[$row['agency_id']][] = $row;
}
?>
<h2 class="mb-4">Organizations</h2>
<a href="organization.php" class="btn btn-sm btn-primary mb-3">Add Organization</a>
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
              <a class="btn btn-sm btn-outline-primary mt-1" href="division.php?agency_id=<?= $agency['id']; ?>">Add Division</a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <p class="ms-3 text-muted">No agencies yet.</p>
      <?php endif; ?>
      <a class="btn btn-sm btn-outline-primary" href="agency.php?organization_id=<?= $org['id']; ?>">Add Agency</a>
    </div>
  </div>
<?php endforeach; ?>
<?php require '../admin_footer.php'; ?>
