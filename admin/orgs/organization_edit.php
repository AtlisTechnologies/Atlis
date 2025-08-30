<?php

require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/helpers.php';
require_once __DIR__ . '/../../includes/hierarchy_file.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
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
  require_permission('organization','update');
  $stmt = $pdo->prepare('SELECT name, main_person, status, file_name, file_path, file_size, file_type FROM module_organization WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $existing = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($existing) {
    $name = $existing['name'];
    $main_person = $existing['main_person'];
    $status = $existing['status'];
    $file_name = $existing['file_name'];
    $file_path = $existing['file_path'];
    $file_size = $existing['file_size'];
    $file_type = $existing['file_type'];
  }
} else {
  require_permission('organization','create');
  $status = (int)get_system_property($pdo, 'DEFAULT_ORGANIZATION_STATUS');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$personStmt = $pdo->query('SELECT id, CONCAT(first_name, " ", last_name) AS name FROM person ORDER BY first_name, last_name');
$personOptions = $personStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusItems   = get_lookup_items($pdo, 'ORGANIZATION_STATUS');
$statusOptions = array_column($statusItems, 'label', 'id');
$roleItems     = get_lookup_items($pdo, 'ORGANIZATION_PERSON_ROLES');
$roleOptions   = array_column($roleItems, 'label', 'id');
$assignedPersons = [];
if ($id) {
  $apStmt = $pdo->prepare('SELECT op.id, op.person_id, op.role_id, op.is_lead, CONCAT(p.first_name," ",p.last_name) AS name, li.label AS role_label
                            FROM module_organization_persons op
                            JOIN person p ON op.person_id = p.id
                            LEFT JOIN lookup_list_items li ON op.role_id = li.id
                            WHERE op.organization_id = :id');
  $apStmt->execute([':id'=>$id]);
  $assignedPersons = $apStmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  if (isset($_POST['remove_file']) && $id) {
    require_permission('organization','update');
    $uploadDir = dirname(__DIR__, 2) . '/module/agency/uploads/organization/';
    if (!empty($file_path)) {
      @unlink($uploadDir . $file_path);
    }
    $pdo->prepare('UPDATE module_organization SET file_name=NULL,file_path=NULL,file_size=NULL,file_type=NULL WHERE id=?')->execute([$id]);
    admin_audit_log($pdo,$this_user_id,'module_organization',$id,'REMOVE_FILE',json_encode(['file_name'=>$file_name,'file_path'=>$file_path]),null,'Removed organization file');
    header('Location: organization_edit.php?id='.$id);
    exit;
  }

  $name = trim($_POST['name'] ?? '');
  $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
  $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_organization SET name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:id');
    $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo, $this_user_id, 'module_organization', $id, 'UPDATE', json_encode($existing), json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Updated organization');
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_organization (name, main_person, status, user_id, user_updated) VALUES (:name, :main_person, :status, :uid, :uid)');
    $stmt->execute([':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_organization', $id, 'CREATE', null, json_encode(['name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Created organization');
  }

  handle_hierarchy_upload($pdo, 'organization', $id, $_FILES['upload_file'] ?? [], $this_user_id, $file_path);
  header('Location: index.php');
  exit;
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Organization</h2>
<div class="card mb-4">
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" id="orgForm">
      <input type="hidden" name="csrf_token" value="<?= $token; ?>">
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
            <a href="/module/agency/download.php?type=organization&id=<?= $id; ?>" target="_blank"><?= e($file_name); ?></a>
            <button class="btn btn-outline-danger btn-sm ms-2" name="remove_file" value="1" formnovalidate>Remove File</button>
            <?php if (strpos($file_type,'image/') === 0): ?>
              <img src="/module/agency/uploads/organization/<?= e($file_path); ?>" class="img-fluid mt-2" alt="Preview">
            <?php elseif ($file_type === 'application/pdf'): ?>
              <embed src="/module/agency/uploads/organization/<?= e($file_path); ?>" type="application/pdf" class="w-100 mt-2" style="height:200px;"></embed>
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
      <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#assignOrgPersonModal">Assign Person</button>
    </div>
    <div class="card-body">
      <table class="table table-sm">
        <thead>
          <tr><th>Name</th><th>Role</th><th>Lead</th><th></th></tr>
        </thead>
        <tbody id="org-persons-body">
          <?php foreach($assignedPersons as $ap): ?>
            <tr>
              <td><?= e($ap['name']); ?></td>
              <td><?= e($ap['role_label'] ?? ''); ?></td>
              <td><?= $ap['is_lead'] ? 'Yes' : 'No'; ?></td>
              <td>
                <button class="btn btn-sm btn-danger remove-person" data-url="functions/organization_remove_person.php" data-assignment-id="<?= $ap['id']; ?>" data-csrf="<?= $token; ?>">Remove</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="assignOrgPersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="assign-person-form" action="functions/organization_assign_person.php" data-target="org-persons-body" data-modal="assignOrgPersonModal" method="post">
          <div class="modal-header">
            <h5 class="modal-title">Assign Person</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
            <input type="hidden" name="organization_id" value="<?= $id; ?>">
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
              <input class="form-check-input" type="checkbox" value="1" name="is_lead" id="orgLeadChk">
              <label class="form-check-label" for="orgLeadChk">Lead</label>
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
