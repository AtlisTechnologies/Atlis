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
    $pathStmt = $pdo->prepare('SELECT file_path FROM module_organization WHERE id = :id');
    $pathStmt->execute([':id' => $id]);
    $filePath = $pathStmt->fetchColumn();
    $subdir = 'organization';
    if ($filePath) {
      $fullPath = dirname(__DIR__,2)."/module/agency/uploads/$subdir/$filePath";
      if (is_file($fullPath)) {
        unlink($fullPath);
        admin_audit_log($pdo, $this_user_id, 'module_organization', $id, 'DELETE', '', json_encode(['file' => $filePath]));
      }
    }
    $stmt = $pdo->prepare('DELETE FROM module_organization WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_organization', $id, 'DELETE', 'Deleted organization');
    $message = 'Organization deleted.';
  } elseif (isset($_POST['delete_agency_id'])) {
    require_permission('agency','delete');
    $id = (int)$_POST['delete_agency_id'];
    $pathStmt = $pdo->prepare('SELECT file_path FROM module_agency WHERE id = :id');
    $pathStmt->execute([':id' => $id]);
    $filePath = $pathStmt->fetchColumn();
    $subdir = 'agency';
    if ($filePath) {
      $fullPath = dirname(__DIR__,2)."/module/agency/uploads/$subdir/$filePath";
      if (is_file($fullPath)) {
        unlink($fullPath);
        admin_audit_log($pdo, $this_user_id, 'module_agency', $id, 'DELETE', '', json_encode(['file' => $filePath]));
      }
    }
    $stmt = $pdo->prepare('DELETE FROM module_agency WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_agency', $id, 'DELETE', 'Deleted agency');
    $message = 'Agency deleted.';
  } elseif (isset($_POST['delete_division_id'])) {
    require_permission('division','delete');
    $id = (int)$_POST['delete_division_id'];
    $pathStmt = $pdo->prepare('SELECT file_path FROM module_division WHERE id = :id');
    $pathStmt->execute([':id' => $id]);
    $filePath = $pathStmt->fetchColumn();
    $subdir = 'division';
    if ($filePath) {
      $fullPath = dirname(__DIR__,2)."/module/agency/uploads/$subdir/$filePath";
      if (is_file($fullPath)) {
        unlink($fullPath);
        admin_audit_log($pdo, $this_user_id, 'module_division', $id, 'DELETE', '', json_encode(['file' => $filePath]));
      }
    }
    $stmt = $pdo->prepare('DELETE FROM module_division WHERE id = :id');
    $stmt->execute([':id' => $id]);
    audit_log($pdo, $this_user_id, 'module_division', $id, 'DELETE', 'Deleted division');
    $message = 'Division deleted.';
  }
}
 
$orgStatuses      = array_column(get_lookup_items($pdo, 'ORGANIZATION_STATUS'), null, 'id');
$orgOptions = $pdo->query('SELECT id,name FROM module_organization ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);

$filterName  = trim($_GET['name'] ?? '');
$filterStatus = $_GET['status'] ?? '';
$filterOrg   = $_GET['organization'] ?? '';

$sql = 'SELECT id,name,status FROM module_organization WHERE 1';
$params = [];
if ($filterName !== '') {
  $sql .= ' AND name LIKE :name';
  $params[':name'] = "%{$filterName}%";
}
if ($filterStatus !== '') {
  $sql .= ' AND status = :status';
  $params[':status'] = $filterStatus;
}
if ($filterOrg !== '') {
  $sql .= ' AND id = :org';
  $params[':org'] = $filterOrg;
}
$sql .= ' ORDER BY name';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);

ob_start();
foreach($organizations as $org): ?>
  <div class="card mb-2" data-org-id="<?= $org['id']; ?>">
    <div class="card-header d-flex justify-content-between align-items-start">
      <div>
        <span class="badge bg-primary me-1">Org</span><span class="fw-semibold"><?= e($org['name']); ?></span>
      </div>
      <div class="text-end">
        <?= render_status_badge($orgStatuses, $org['status']); ?>
        <div class="mt-2">
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
        </div>
      </div>
    </div>
    <div class="accordion" id="agencyAcc<?= $org['id']; ?>">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $org['id']; ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $org['id']; ?>">Agencies</button>
        </h2>
        <div id="collapse<?= $org['id']; ?>" class="accordion-collapse collapse" data-type="agencies" data-parent-id="<?= $org['id']; ?>">
          <div class="accordion-body"></div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; $orgListHtml = ob_get_clean();

if (isset($_GET['partial'])) {
  echo $orgListHtml;
  exit;
}
?>
<h2 class="mb-4">Organizations</h2>
<?php if($message){ echo '<div class="alert alert-success">'.e($message).'</div>'; } ?>
<?php if (user_has_permission('organization','create')): ?>
  <a href="organization_edit.php" class="btn btn-sm btn-success mb-3">Add Organization</a>
<?php endif; ?>
<form id="orgFilterForm" class="row g-2 mb-3">
  <div class="col-auto">
    <input type="text" name="name" value="<?= e($filterName); ?>" class="form-control form-control-sm" placeholder="Name">
  </div>
  <div class="col-auto">
    <select name="status" class="form-select form-select-sm">
      <option value="">Status</option>
      <?php foreach($orgStatuses as $os){ echo '<option value="'.$os['id'].'"'.($filterStatus==$os['id']?' selected':'').'>'.e($os['label']).'</option>'; } ?>
    </select>
  </div>
  <div class="col-auto">
    <select name="organization" class="form-select form-select-sm">
      <option value="">Organization</option>
      <?php foreach($orgOptions as $o){ echo '<option value="'.$o['id'].'"'.($filterOrg==$o['id']?' selected':'').'>'.e($o['name']).'</option>'; } ?>
    </select>
  </div>
  <div class="col-auto">
    <button class="btn btn-sm btn-primary" type="submit">Filter</button>
  </div>
</form>
<div id="orgList">
  <?= $orgListHtml; ?>
</div>
<script>const csrfToken = '<?= $token; ?>';</script>
<?php $loadFsLightbox = true; ?>
<script src="assets/orgs.js"></script>
<?php require '../admin_footer.php'; ?>
