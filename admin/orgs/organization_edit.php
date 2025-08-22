<?php

require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/helpers.php';

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
  // handle file upload (max 5MB)
  if (!empty($_FILES['upload_file']['name'])) {
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($_FILES['upload_file']['size'] <= $maxSize && is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
      $originalName = $_FILES['upload_file']['name'];
      $fileSize = (int)$_FILES['upload_file']['size'];

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $_FILES['upload_file']['tmp_name']);
      finfo_close($finfo);

      $allowedTypes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf'
      ];

      if (isset($allowedTypes[$mime])) {
        $ext = $allowedTypes[$mime];
        $uploadDir = dirname(__DIR__, 3) . '/uploads/organization/';
        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0775, true);
        }
        if (!empty($file_path)) {
          @unlink($uploadDir . $file_path);
        }
        $randomName = bin2hex(random_bytes(16)) . '.' . $ext;
        $dest = $uploadDir . $randomName;
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest)) {
          $fileStmt = $pdo->prepare('UPDATE module_organization SET file_name=?, file_path=?, file_size=?, file_type=? WHERE id=?');
          $fileStmt->execute([$originalName, $randomName, $fileSize, $mime, $id]);
          admin_audit_log($pdo, $this_user_id, 'module_organization', $id, 'UPLOAD', null, json_encode(['file_name'=>$originalName,'file_path'=>$randomName,'file_size'=>$fileSize,'file_type'=>$mime]), 'Uploaded organization file');
        }
      }
    }
  }
  header('Location: index.php');
  exit;
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Organization</h2>
<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Main Person</label>
    <select name="main_person" class="form-select">
      <option value="">-- None --</option>
      <?php foreach($personOptions as $pid => $pname): ?>
        <option value="<?= $pid; ?>" <?= (int)$pid === (int)$main_person ? 'selected' : ''; ?>><?= htmlspecialchars($pname); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php foreach($statusOptions as $sid => $slabel): ?>
        <option value="<?= $sid; ?>" <?= (int)$sid === (int)$status ? 'selected' : ''; ?>><?= htmlspecialchars($slabel); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Upload File</label>
    <?php if ($file_path): ?>
      <div class="mb-2">
        <a href="/module/organization/download.php?id=<?= $id; ?>" target="_blank"><?= htmlspecialchars($file_name); ?></a>
      </div>
    <?php endif; ?>
    <input type="file" name="upload_file" class="form-control" accept="image/*,application/pdf">
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<?php if ($id): ?>
  <hr class="my-4">
  <h4>Assigned Persons</h4>
  <table class="table table-sm">
    <thead>
      <tr><th>Name</th><th>Role</th><th>Lead</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach($assignedPersons as $ap): ?>
        <tr>
          <td><?= htmlspecialchars($ap['name']); ?></td>
          <td><?= htmlspecialchars($ap['role_label'] ?? ''); ?></td>
          <td><?= $ap['is_lead'] ? 'Yes' : 'No'; ?></td>
          <td>
            <form method="post" action="functions/organization_remove_person.php" class="d-inline">
              <input type="hidden" name="assignment_id" value="<?= $ap['id']; ?>">
              <input type="hidden" name="organization_id" value="<?= $id; ?>">
              <input type="hidden" name="csrf_token" value="<?= $token; ?>">
              <button class="btn btn-sm btn-danger" onclick="return confirm('Remove this person?');">Remove</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <form method="post" action="functions/organization_assign_person.php" class="row g-2">
    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
    <input type="hidden" name="organization_id" value="<?= $id; ?>">
    <div class="col-md-4">
      <select name="person_id" class="form-select" required>
        <option value="">-- Person --</option>
        <?php foreach($personOptions as $pid=>$pname): ?>
          <option value="<?= $pid; ?>"><?= htmlspecialchars($pname); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <select name="role_id" class="form-select">
        <option value="">-- Role --</option>
        <?php foreach($roleOptions as $rid=>$rlabel): ?>
          <option value="<?= $rid; ?>"><?= htmlspecialchars($rlabel); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2 form-check d-flex align-items-center">
      <input class="form-check-input" type="checkbox" value="1" name="is_lead" id="orgLeadChk">
      <label class="form-check-label ms-2" for="orgLeadChk">Lead</label>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary" type="submit">Assign</button>
    </div>
  </form>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
