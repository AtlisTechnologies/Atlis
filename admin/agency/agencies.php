<?php
require '../admin_header.php';

$organization_id = isset($_GET['organization_id']) ? (int)$_GET['organization_id'] : 0;
if(!$organization_id) {
  die('Organization ID required');
}

$orgStmt = $pdo->prepare('SELECT name FROM module_organization WHERE id = :id');
$orgStmt->execute([':id'=>$organization_id]);
$organization = $orgStmt->fetch(PDO::FETCH_ASSOC);
if(!$organization) {
  die('Organization not found');
}

$stmt = $pdo->prepare('SELECT id, name FROM module_agency WHERE organization_id = :org_id ORDER BY name');
$stmt->execute([':org_id'=>$organization_id]);
$agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Agencies for <?= htmlspecialchars($organization['name']); ?></h2>
<a href="agency_edit.php?organization_id=<?= $organization_id; ?>" class="btn btn-sm btn-phoenix-success mb-3">Add Agency</a>
<div id="agencies" data-list='{"valueNames":["id","name"],"page":10,"pagination":true}'>
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
        <?php foreach($agencies as $a): ?>
          <tr>
            <td class="id"><?= htmlspecialchars($a['id']); ?></td>
            <td class="name"><?= htmlspecialchars($a['name']); ?></td>
            <td>
              <a class="btn btn-sm btn-phoenix-warning" href="agency_edit.php?id=<?= $a['id']; ?>&organization_id=<?= $organization_id; ?>">Edit</a>
              <a class="btn btn-sm btn-phoenix-info" href="divisions.php?agency_id=<?= $a['id']; ?>">Divisions</a>
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
<?php require '../admin_footer.php'; ?>
