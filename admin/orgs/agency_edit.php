<?php
require '../admin_header.php';

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
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$orgStmt = $pdo->query('SELECT id, name FROM module_organization ORDER BY name');
$orgOptions = $orgStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$personStmt = $pdo->query('SELECT id, CONCAT(first_name, " ", last_name) AS name FROM person ORDER BY first_name, last_name');
$personOptions = $personStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusStmt = $pdo->prepare("SELECT li.id, li.label FROM lookup_list_items li JOIN lookup_lists l ON li.list_id = l.id WHERE l.name = 'AGENCY_STATUS' AND li.active_from <= CURDATE() AND (li.active_to IS NULL OR li.active_to >= CURDATE()) ORDER BY li.sort_order, li.label");
$statusStmt->execute();
$statusOptions = $statusStmt->fetchAll(PDO::FETCH_KEY_PAIR);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
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
  // handle file upload (max 5MB) saved to /module/agency/uploads/
  if (!empty($_FILES['upload_file']['name'])) {
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($_FILES['upload_file']['size'] <= $maxSize && is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
      $originalName = $_FILES['upload_file']['name'];
      $fileSize = (int)$_FILES['upload_file']['size'];
      $fileType = $_FILES['upload_file']['type'];
      $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
      $uploadDir = __DIR__ . '/../../module/agency/uploads/';
      if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0775, true);
      }
      foreach (glob($uploadDir . 'agency_' . $id . '.*') as $old) {
        @unlink($old);
      }
      $dest = $uploadDir . 'agency_' . $id . '.' . $ext;
      $publicPath = '/module/agency/uploads/agency_' . $id . '.' . $ext;
      if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $dest)) {
        $fileStmt = $pdo->prepare('UPDATE module_agency SET file_name=?, file_path=?, file_size=?, file_type=? WHERE id=?');
        $fileStmt->execute([$originalName, $publicPath, $fileSize, $fileType, $id]);
      }
    }
  }

  header('Location: index.php');
  exit;
}
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Agency</h2>

<form method="post" enctype="multipart/form-data">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Organization</label>
    <select name="organization_id" class="form-select" required>
      <option value="">-- Select --</option>
      <?php foreach($orgOptions as $oid => $oname): ?>
        <option value="<?= $oid; ?>" <?= (int)$oid === (int)$organization_id ? 'selected' : ''; ?>><?= htmlspecialchars($oname); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
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
        <a href="<?= htmlspecialchars($file_path); ?>" target="_blank"><?= htmlspecialchars($file_name); ?></a>
      </div>
    <?php endif; ?>
    <input type="file" name="upload_file" class="form-control" accept="image/*,application/pdf">
  </div>

  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require '../admin_footer.php'; ?>
