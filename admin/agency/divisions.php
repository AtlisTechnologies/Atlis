<?php
require '../admin_header.php';

$agency_id = isset($_GET['agency_id']) ? (int)$_GET['agency_id'] : 0;
if(!$agency_id) { die('Agency ID required'); }

$agencyStmt = $pdo->prepare('SELECT name, organization_id FROM module_agency WHERE id = :id');
$agencyStmt->execute([':id'=>$agency_id]);
$agency = $agencyStmt->fetch(PDO::FETCH_ASSOC);
if(!$agency) { die('Agency not found'); }

$divStmt = $pdo->prepare('SELECT id, name FROM module_division WHERE agency_id = :agency_id ORDER BY name');
$divStmt->execute([':agency_id'=>$agency_id]);
$divisions = $divStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Divisions for <?= htmlspecialchars($agency['name']); ?></h2>
<a href="division_edit.php?agency_id=<?= $agency_id; ?>" class="btn btn-sm btn-phoenix-success mb-3">Add Division</a>
<div id="divisions" data-list='{"valueNames":["id","name"],"page":10,"pagination":true}'>
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
        <?php foreach($divisions as $d): ?>
          <tr>
            <td class="id"><?= htmlspecialchars($d['id']); ?></td>
            <td class="name"><?= htmlspecialchars($d['name']); ?></td>
            <td>
              <a class="btn btn-sm btn-phoenix-warning" href="division_edit.php?id=<?= $d['id']; ?>&agency_id=<?= $agency_id; ?>">Edit</a>
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
