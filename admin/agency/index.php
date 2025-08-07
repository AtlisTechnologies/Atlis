<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

// Fetch organizations
$stmt = $pdo->query('SELECT id, name FROM module_organization ORDER BY name');
$organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Organizations</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<a href="organization_edit.php" class="btn btn-sm btn-phoenix-success mb-3">Add Organization</a>
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
              <a class="btn btn-sm btn-phoenix-warning" href="organization_edit.php?id=<?= $o['id']; ?>">Edit</a>
              <a class="btn btn-sm btn-phoenix-info" href="agencies.php?organization_id=<?= $o['id']; ?>">Agencies</a>
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
