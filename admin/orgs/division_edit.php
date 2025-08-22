<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/helpers.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$agency_id = isset($_GET['agency_id']) ? (int)$_GET['agency_id'] : null;
$name = '';
$main_person = null;
$status = null;
$existing = null;
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('division','update');
  $stmt = $pdo->prepare('SELECT agency_id, name, main_person, status FROM module_division WHERE id = :id');
  $stmt->execute([':id' => $id]);
  $existing = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($existing) {
    $agency_id = $existing['agency_id'];
    $name = $existing['name'];
    $main_person = $existing['main_person'];
    $status = $existing['status'];
  }
} else {
  require_permission('division','create');
  $status = (int)get_system_property($pdo, 'DEFAULT_DIVISION_STATUS');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $agency_id = $_POST['agency_id'] !== '' ? (int)$_POST['agency_id'] : null;
  $name = trim($_POST['name'] ?? '');
  $main_person = $_POST['main_person'] !== '' ? (int)$_POST['main_person'] : null;
  $status = $_POST['status'] !== '' ? (int)$_POST['status'] : null;
  if ($id) {
    $stmt = $pdo->prepare('UPDATE module_division SET agency_id=:agency_id, name=:name, main_person=:main_person, status=:status, user_updated=:uid WHERE id=:id');
    $stmt->execute([':agency_id'=>$agency_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo, $this_user_id, 'module_division', $id, 'UPDATE', json_encode($existing), json_encode(['agency_id'=>$agency_id,'name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Updated division');
  } else {
    $stmt = $pdo->prepare('INSERT INTO module_division (agency_id, name, main_person, status, user_id, user_updated) VALUES (:agency_id, :name, :main_person, :status, :uid, :uid)');
    $stmt->execute([':agency_id'=>$agency_id, ':name'=>$name, ':main_person'=>$main_person, ':status'=>$status, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'module_division', $id, 'CREATE', null, json_encode(['agency_id'=>$agency_id,'name'=>$name,'main_person'=>$main_person,'status'=>$status]), 'Created division');
  }
  header('Location: index.php');
  exit;
}

$agencyStmt = $pdo->query('SELECT a.id, CONCAT(o.name, " - ", a.name) AS name FROM module_agency a JOIN module_organization o ON a.organization_id = o.id ORDER BY o.name, a.name');
$agencyOptions = $agencyStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$personStmt = $pdo->query('SELECT id, CONCAT(first_name, " ", last_name) AS name FROM person ORDER BY first_name, last_name');
$personOptions = $personStmt->fetchAll(PDO::FETCH_KEY_PAIR);

$statusItems   = get_lookup_items($pdo, 'DIVISION_STATUS');
$statusOptions = array_column($statusItems, 'label', 'id');
$roleItems     = get_lookup_items($pdo, 'DIVISION_PERSON_ROLES');
$roleOptions   = array_column($roleItems, 'label', 'id');
$assignedPersons = [];
if ($id) {
  $apStmt = $pdo->prepare('SELECT dp.id, dp.person_id, dp.role_id, dp.is_lead, CONCAT(p.first_name," ",p.last_name) AS name, li.label AS role_label
                            FROM module_division_persons dp
                            JOIN person p ON dp.person_id = p.id
                            LEFT JOIN lookup_list_items li ON dp.role_id = li.id
                            WHERE dp.division_id = :id');
  $apStmt->execute([':id'=>$id]);
  $assignedPersons = $apStmt->fetchAll(PDO::FETCH_ASSOC);
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Division</h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">Agency</label>
    <select name="agency_id" class="form-select" required>
      <option value="">-- Select --</option>
      <?php foreach($agencyOptions as $aid => $aname): ?>
        <option value="<?= $aid; ?>" <?= (int)$aid === (int)$agency_id ? 'selected' : ''; ?>><?= htmlspecialchars($aname); ?></option>
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
            <form method="post" action="functions/division_remove_person.php" class="d-inline">
              <input type="hidden" name="assignment_id" value="<?= $ap['id']; ?>">
              <input type="hidden" name="division_id" value="<?= $id; ?>">
              <input type="hidden" name="csrf_token" value="<?= $token; ?>">
              <button class="btn btn-sm btn-danger" onclick="return confirm('Remove this person?');">Remove</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <form method="post" action="functions/division_assign_person.php" class="row g-2">
    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
    <input type="hidden" name="division_id" value="<?= $id; ?>">
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
      <input class="form-check-input" type="checkbox" value="1" name="is_lead" id="divisionLeadChk">
      <label class="form-check-label ms-2" for="divisionLeadChk">Lead</label>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary" type="submit">Assign</button>
    </div>
  </form>
<?php endif; ?>
<?php require '../admin_footer.php'; ?>
