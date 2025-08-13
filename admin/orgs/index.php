<?php
require '../admin_header.php';
require_permission('organization','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  if (isset($_POST['delete_organization_id'])) {
    require_permission('organization','delete');
    $id = (int)$_POST['delete_organization_id'];
    $stmt = $pdo->prepare('DELETE FROM module_organization WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_organization', $id, 'DELETE', 'Deleted organization');
    $message = 'Organization deleted.';
  } elseif (isset($_POST['delete_agency_id'])) {
    require_permission('agency','delete');
    $id = (int)$_POST['delete_agency_id'];
    $stmt = $pdo->prepare('DELETE FROM module_agency WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_agency', $id, 'DELETE', 'Deleted agency');
    $message = 'Agency deleted.';
  } elseif (isset($_POST['delete_division_id'])) {
    require_permission('division','delete');
    $id = (int)$_POST['delete_division_id'];
    $stmt = $pdo->prepare('DELETE FROM module_division WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_division', $id, 'DELETE', 'Deleted division');
    $message = 'Division deleted.';
  }
}

$orgStatuses      = array_column(get_lookup_items($pdo, 'ORGANIZATION_STATUS'), null, 'id');
$agencyStatuses   = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$divisionStatuses = array_column(get_lookup_items($pdo, 'DIVISION_STATUS'), null, 'id');


$orgStmt = $pdo->query('SELECT id, name, status FROM module_organization ORDER BY name');
$organizations = $orgStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Organizations</h2>
<?php if($message){ echo '<div class="alert alert-success">'.htmlspecialchars($message).'</div>'; } ?>
<?php if (user_has_permission('organization','create')): ?>
  <a href="organization_edit.php" class="btn btn-sm btn-success mb-3">Add Organization</a>
<?php endif; ?>
<div class="table-responsive">
  <table class="table fs-9 mb-0 border-top border-translucent">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($organizations as $org): ?>
        <tr>
          <td><?= htmlspecialchars($org['name']); ?></td>
          <td>
            <?php $status = $orgStatuses[$org['status']] ?? null; $class = $status['color_class'] ?? 'secondary'; ?>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($class); ?>"><span class="badge-label"><?= htmlspecialchars($status['label'] ?? ''); ?></span></span>
          </td>
          <td>
            <a class="btn btn-sm btn-warning" href="organization_edit.php?id=<?= $org['id']; ?>">Edit</a>
            <?php if (user_has_permission('organization','delete')): ?>
              <form method="post" class="d-inline">
                <input type="hidden" name="delete_organization_id" value="<?= $org['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this organization?');">Delete</button>
              </form>
            <?php endif; ?>
            <?php if (user_has_permission('agency','create')): ?>
              <a class="btn btn-sm btn-success" href="agency_edit.php?organization_id=<?= $org['id']; ?>">Add Agency</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php
          $agencyStmt = $pdo->prepare('SELECT id, name, status, file_path, file_name, file_type FROM module_agency WHERE organization_id = :oid ORDER BY name');
          $agencyStmt->execute([':oid' => $org['id']]);
          $agencies = $agencyStmt->fetchAll(PDO::FETCH_ASSOC);
          foreach($agencies as $agency): ?>
          <tr class="bg-body-tertiary">
            <td class="ps-4">Agency: <?= htmlspecialchars($agency['name']); ?>
              <?php if(!empty($agency['file_path'])): ?>
                <br><a href="/module/agency/download.php?id=<?= $agency['id']; ?>" target="_blank">View File</a>
              <?php endif; ?>
            </td>
            <td>
              <?php $aStatus = $agencyStatuses[$agency['status']] ?? null; $aClass = $aStatus['color_class'] ?? 'secondary'; ?>
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($aClass); ?>"><span class="badge-label"><?= htmlspecialchars($aStatus['label'] ?? ''); ?></span></span>
            </td>
            <td>
              <a class="btn btn-sm btn-warning" href="agency_edit.php?id=<?= $agency['id']; ?>">Edit</a>
              <?php if (user_has_permission('agency','delete')): ?>
                <form method="post" class="d-inline">
                  <input type="hidden" name="delete_agency_id" value="<?= $agency['id']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this agency?');">Delete</button>
                </form>
              <?php endif; ?>
              <?php if (user_has_permission('division','create')): ?>
                <a class="btn btn-sm btn-success" href="division_edit.php?agency_id=<?= $agency['id']; ?>">Add Division</a>
              <?php endif; ?>
            </td>
          </tr>
          <?php
            $divisionStmt = $pdo->prepare('SELECT id, name, status FROM module_division WHERE agency_id = :aid ORDER BY name');
            $divisionStmt->execute([':aid' => $agency['id']]);
            $divisions = $divisionStmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($divisions as $division): ?>
            <tr class="bg-body-secondary">
              <td class="ps-5">Division: <?= htmlspecialchars($division['name']); ?></td>
              <td>
                <?php $dStatus = $divisionStatuses[$division['status']] ?? null; $dClass = $dStatus['color_class'] ?? 'secondary'; ?>
                <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($dClass); ?>"><span class="badge-label"><?= htmlspecialchars($dStatus['label'] ?? ''); ?></span></span>
              </td>
              <td>
                <a class="btn btn-sm btn-warning" href="division_edit.php?id=<?= $division['id']; ?>">Edit</a>
                <?php if (user_has_permission('division','delete')): ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="delete_division_id" value="<?= $division['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this division?');">Delete</button>
                  </form>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          <?php endforeach; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require '../admin_footer.php'; ?>
