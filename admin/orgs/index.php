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
$agencyStatuses   = array_column(get_lookup_items($pdo, 'AGENCY_STATUS'), null, 'id');
$divisionStatuses = array_column(get_lookup_items($pdo, 'DIVISION_STATUS'), null, 'id');

function render_file_attachment($file_path, $file_name, $file_type, $downloadUrl, $subdir) {
  if (empty($file_name)) {
    return '';
  }
  $path = $file_path;
  if (strpos($path, '/') !== 0) {
    $path = "/module/agency/uploads/{$subdir}/{$path}";
  }
  $src = getURLDir() . ltrim($path, '/');
  $downloadUrl = e($downloadUrl, ENT_QUOTES);
  $escName = e($file_name);
  $srcEsc = e($src, ENT_QUOTES);
  $download = "<a href=\"{$downloadUrl}\" class=\"ms-2\" download><span class=\"fas fa-download\"></span></a>";
  if (strpos($file_type, 'image/') === 0 || $file_type === 'application/pdf') {
    $preview = strpos($file_type, 'image/') === 0 ? "<img src=\"{$srcEsc}\" class=\"img-thumbnail\" style=\"max-width:100px;\" alt=\"{$escName}\">" : "<span class=\"fas fa-file-pdf me-1\"></span>{$escName}";
    return "<div class=\"mt-2\"><a href=\"{$srcEsc}\" data-fslightbox>{$preview}</a>{$download}</div>";
  }
  return "<div class=\"mt-2\"><a href=\"{$downloadUrl}\" class=\"d-inline-flex align-items-center\" download><span class=\"fas fa-paperclip me-1\"></span>{$escName}</a>{$download}</div>";
}

if (isset($_GET['ajax'])) {
  $parentId = (int)($_GET['parent_id'] ?? 0);
  $type = $_GET['ajax'];
  if ($type === 'agencies') {
    require_permission('agency', 'read');
    $stmt = $pdo->prepare('SELECT id,name,status,file_path,file_name,file_type FROM module_agency WHERE organization_id = :id ORDER BY name');
    $stmt->execute([':id' => $parentId]);
    $agencies = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($agencies as $agency) {
      $status = e($agencyStatuses[$agency['status']]['label'] ?? '');
      $attachment = render_file_attachment($agency['file_path'], $agency['file_name'], $agency['file_type'], "/module/agency/download.php?type=agency&id={$agency['id']}", 'agency');
      echo "<div class='accordion-item'><h2 class='accordion-header'><button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#div{$agency['id']}'>" . e($agency['name']) . "<span class='badge bg-secondary ms-2'>{$status}</span></button></h2><div id='div{$agency['id']}' class='accordion-collapse collapse' data-type='divisions' data-parent-id='{$agency['id']}'><div class='accordion-body'>{$attachment}</div></div></div>";
    }
    exit;
  } elseif ($type === 'divisions') {
    require_permission('division', 'read');
    $stmt = $pdo->prepare('SELECT id,name,status,file_path,file_name,file_type FROM module_division WHERE agency_id = :id ORDER BY name');
    $stmt->execute([':id' => $parentId]);
    $divisions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<ul class="list-group">';
    foreach ($divisions as $div) {
      $status = e($divisionStatuses[$div['status']]['label'] ?? '');
      $attachment = render_file_attachment($div['file_path'], $div['file_name'], $div['file_type'], "/module/agency/download.php?type=division&id={$div['id']}", 'division');
      echo "<li class='list-group-item d-flex justify-content-between align-items-start'><div><span class='fw-semibold'>" . e($div['name']) . "</span>{$attachment}</div><span class='badge bg-secondary'>{$status}</span></li>";
    }
    echo '</ul>';
    exit;
  }
}

$stmt = $pdo->query('SELECT id,name,status,file_path,file_name,file_type FROM module_organization ORDER BY name');
$organizations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Organizations</h2>
<?php if($message){ echo '<div class="alert alert-success">'.e($message).'</div>'; } ?>
<?php if (user_has_permission('organization','create')): ?>
  <a href="organization_edit.php" class="btn btn-sm btn-success mb-3">Add Organization</a>
<?php endif; ?>
<div id="orgList" data-list='{"valueNames":["org-name","org-status"],"page":20,"pagination":true}'>
  <div class="row g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search name" />
    </div>
    <div class="col-auto">
      <select id="statusFilter" class="form-select form-select-sm">
        <option value="">Status</option>
        <?php foreach($orgStatuses as $os){ echo '<option value="'.e($os['label']).'">'.e($os['label']).'</option>'; } ?>
      </select>
    </div>
    <div class="col-auto">
      <select id="orgFilter" class="form-select form-select-sm">
        <option value="">Organization</option>
        <?php foreach($organizations as $o){ echo '<option value="'.$o['id'].'">'.e($o['name']).'</option>'; } ?>
      </select>
    </div>
  </div>
  <div class="list">
    <?php foreach($organizations as $org): ?>
      <div class="card mb-2 item" data-org-id="<?= $org['id']; ?>">
        <div class="card-header d-flex justify-content-between align-items-start">
          <div>
            <span class="badge bg-primary me-1">Org</span><span class="fw-semibold org-name"><?= e($org['name']); ?></span>
            <?= render_file_attachment($org['file_path'], $org['file_name'], $org['file_type'], "/module/agency/download.php?type=organization&id={$org['id']}", 'organization'); ?>
          </div>
          <div class="text-end">
            <span class="org-status d-none"><?= e($orgStatuses[$org['status']]['label'] ?? ''); ?></span>
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
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $org['id']; ?>" aria-expanded="false">Agencies</button>
            </h2>
            <div id="collapse<?= $org['id']; ?>" class="accordion-collapse collapse" data-type="agencies" data-parent-id="<?= $org['id']; ?>">
              <div class="accordion-body"></div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<?php $loadFsLightbox = true; ?>
<script src="assets/orgs.js"></script>
<?php require '../admin_footer.php'; ?>
