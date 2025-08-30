<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/hierarchy_file.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$organization_id = isset($_GET['organization_id']) ? (int)$_GET['organization_id'] : null;
$name = '';
$main_person = null;
$status = null;
$existing = null;
$file_name = '';
$file_path = '';
$file_size = null;
$file_type = '';
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('agency','update');
  $stmt = $pdo->prepare('SELECT organization_id, name, main_person, status, file_name, file_path, file_size, file_type FROM module_agency WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $existing = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($existing) {
    $organization_id = $existing['organization_id'];
    $name = $existing['name'];
    $main_person = $existing['main_person'];
    $status = $existing['status'];
    $file_name = $existing['file_name'];
    $file_path = $existing['file_path'];
    $file_size = $existing['file_size'];
    $file_type = $existing['file_type'];
  }
} else {
  require_permission('agency','create');
  $status = (int)get_system_property($pdo, 'DEFAULT_AGENCY_STATUS');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  if (isset($_POST['remove_file']) && $id) {
    require_permission('agency','update');
    $uploadDir = dirname(__DIR__, 2) . '/module/agency/uploads/agency/';
    if (!empty($file_path)) {
      @unlink($uploadDir . $file_path);
    }
    $pdo->prepare('UPDATE module_agency SET file_name=NULL,file_path=NULL,file_size=NULL,file_type=NULL WHERE id=?')->execute([$id]);
    admin_audit_log($pdo,$this_user_id,'module_agency',$id,'REMOVE_FILE',json_encode(['file_name'=>$file_name,'file_path'=>$file_path]),null,'Removed agency file');
    header('Location: agency_edit.php?id='.$id);
    exit;
  }

  $organization_id = $_POST['organization_id'] !== '' ? (int)$_POST['organization_id'] : null;
  $name = trim($_POST['name'] ?? '');
  $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
  $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_agency SET organization_id=:organization_id, name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:id');
    $stmt->execute([':organization_id'=>$organization_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo, $this_user_id, 'module_agency', $id, 'UPDATE', json_encode($existing), json_encode(['organization_id'=>$organization_id,'name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Updated agency');
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_agency (organization_id, name, main_person, status, user_id, user_updated) VALUES (:organization_id, :name, :main_person, :status, :uid, :uid)');
    $stmt->execute([':organization_id'=>$organization_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_agency', $id, 'CREATE', null, json_encode(['organization_id'=>$organization_id,'name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Created agency');
  }

  handle_hierarchy_upload($pdo, 'agency', $id, $_FILES['upload_file'] ?? [], $this_user_id, $file_path);

  header('Location: index.php');
  exit;
}

$orgStmt = $pdo->query('SELECT id, name FROM module_organization ORDER BY name');
$orgOptions = $orgStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$personStmt = $pdo->query('SELECT id, CONCAT(first_name, " ", last_name) AS name FROM person ORDER BY first_name, last_name');
$personOptions = $personStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusItems   = get_lookup_items($pdo, 'AGENCY_STATUS');
$statusOptions = array_column($statusItems, 'label', 'id');
$roleItems     = get_lookup_items($pdo, 'AGENCY_PERSON_ROLES');
$roleOptions   = array_column($roleItems, 'label', 'id');
$assignedPersons = [];
if ($id) {
  $apStmt = $pdo->prepare('SELECT ap.id, ap.person_id, ap.role_id, ap.is_lead, CONCAT(p.first_name," ",p.last_name) AS name, li.label AS role_label
                            FROM module_agency_persons ap
                            JOIN person p ON ap.person_id = p.id
                            LEFT JOIN lookup_list_items li ON ap.role_id = li.id
                            WHERE ap.agency_id = :id');
  $apStmt->execute([':id'=>$id]);
  $assignedPersons = $apStmt->fetchAll(PDO::FETCH_ASSOC);
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Agency</h2>

<div class="card mb-4">
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" id="agencyForm">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
      <div class="mb-3">
        <label class="form-label">Organization</label>
        <select name="organization_id" class="form-select" required>
          <option value="">-- Select --</option>
          <?php foreach($orgOptions as $oid => $oname): ?>
            <option value="<?= $oid; ?>" <?= (int)$oid === (int)$organization_id ? 'selected' : ''; ?>><?= e($oname); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="<?= e($name); ?>" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Main Person</label>
        <select name="main_person" class="form-select">
          <option value="">-- None --</option>
          <?php foreach($personOptions as $pid => $pname): ?>
            <option value="<?= $pid; ?>" <?= (int)$pid === (int)$main_person ? 'selected' : ''; ?>><?= e($pname); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
          <?php foreach($statusOptions as $sid => $slabel): ?>
            <option value="<?= $sid; ?>" <?= (int)$sid === (int)$status ? 'selected' : ''; ?>><?= e($slabel); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Upload File</label>
        <?php if ($file_path): ?>
          <div class="mb-2">
            <a href="/module/agency/download.php?type=agency&id=<?= $id; ?>" target="_blank"><?= e($file_name); ?></a>
            <button class="btn btn-outline-danger btn-sm ms-2" name="remove_file" value="1" formnovalidate>Remove File</button>
            <?php if (strpos($file_type,'image/') === 0): ?>
              <img src="/module/agency/uploads/agency/<?= e($file_path); ?>" class="img-fluid mt-2" alt="Preview">
            <?php elseif ($file_type === 'application/pdf'): ?>
              <embed src="/module/agency/uploads/agency/<?= e($file_path); ?>" type="application/pdf" class="w-100 mt-2" style="height:200px;"></embed>
            <?php endif; ?>
          </div>
        <?php endif; ?>
        <input type="file" name="upload_file" class="form-control" accept="image/*,application/pdf">
      </div>
      <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php if ($id): ?>
  <div class="card" id="persons">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="mb-0">Assigned Persons</h4>
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignAgencyPersonModal">Assign Person</button>
    </div>
    <div class="card-body">
      <table class="table table-sm">
        <thead>
          <tr><th>Name</th><th>Role</th><th>Lead</th><th></th></tr>
        </thead>
        <tbody id="agency-persons-body">
          <?php foreach($assignedPersons as $ap): ?>
            <tr>
              <td><?= e($ap['name']); ?></td>
              <td><?= e($ap['role_label'] ?? ''); ?></td>
              <td><?= $ap['is_lead'] ? 'Yes' : 'No'; ?></td>
              <td>
                <button class="btn btn-sm btn-danger remove-person" data-url="functions/agency_remove_person.php" data-assignment-id="<?= $ap['id']; ?>" data-csrf="<?= $token; ?>">Remove</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="assignAgencyPersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="assign-person-form" action="functions/agency_assign_person.php" data-target="agency-persons-body" data-modal="assignAgencyPersonModal" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Assign Person</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
            <input type="hidden" name="agency_id" value="<?= $id; ?>">
            <div class="mb-3">
              <select name="person_id" class="form-select" required>
                <option value="">-- Person --</option>
                <?php foreach($personOptions as $pid=>$pname): ?>
                  <option value="<?= $pid; ?>"><?= e($pname); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <select name="role_id" class="form-select">
                <option value="">-- Role --</option>
                <?php foreach($roleOptions as $rid=>$rlabel): ?>
                  <option value="<?= $rid; ?>"><?= e($rlabel); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" value="1" name="is_lead" id="agencyLeadChk">
              <label class="form-check-label" for="agencyLeadChk">Lead</label>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Assign</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>
<?php $loadFsLightbox = true; ?>
<script src="assets/orgs.js"></script>
<?php require '../admin_footer.php'; ?>
