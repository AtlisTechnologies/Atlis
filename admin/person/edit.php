<?php
require_once '../includes/admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$first_name = $last_name = $email = $phone = $dob = $address = '';
$gender_id = null;
$existing = null;
$btnClass = $id ? 'btn-warning' : 'btn-success';

if ($id) {
  require_permission('person','update');
  $stmt = $pdo->prepare('SELECT * FROM person WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['user_id']) {
      header('Location: ../users/edit.php?id=' . $row['user_id']);
      exit;
    }
    $existing = $row;
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
    $email = $row['email'] ?? '';
    $phone = $row['phone'] ?? '';
    $gender_id = $row['gender_id'] ?? null;
    $dob = $row['dob'] ?? '';
    $address = $row['address'] ?? '';
  }
} else {
  require_permission('person','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

$genderItems = get_lookup_items($pdo, 'USER_GENDER');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $gender_id = $_POST['gender_id'] !== '' ? (int)$_POST['gender_id'] : null;
  $dob = $_POST['dob'] !== '' ? $_POST['dob'] : null;
  $address = trim($_POST['address'] ?? '');
  if ($id) {
    $stmt = $pdo->prepare('UPDATE person SET first_name=:first_name, last_name=:last_name, email=:email, phone=:phone, gender_id=:gender_id, dob=:dob, address=:address, user_updated=:uid WHERE id=:id');
    $stmt->execute([':first_name'=>$first_name, ':last_name'=>$last_name, ':email'=>$email, ':phone'=>$phone, ':gender_id'=>$gender_id, ':dob'=>$dob, ':address'=>$address, ':uid'=>$this_user_id, ':id'=>$id]);
    admin_audit_log($pdo, $this_user_id, 'person', $id, 'UPDATE', json_encode($existing), json_encode(['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'phone'=>$phone,'gender_id'=>$gender_id,'dob'=>$dob,'address'=>$address]), 'Updated person');
  } else {
    $stmt = $pdo->prepare('INSERT INTO person (first_name, last_name, email, phone, gender_id, dob, address, user_updated) VALUES (:first_name, :last_name, :email, :phone, :gender_id, :dob, :address, :uid)');
    $stmt->execute([':first_name'=>$first_name, ':last_name'=>$last_name, ':email'=>$email, ':phone'=>$phone, ':gender_id'=>$gender_id, ':dob'=>$dob, ':address'=>$address, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'person', $id, 'CREATE', null, json_encode(['first_name'=>$first_name,'last_name'=>$last_name,'email'=>$email,'phone'=>$phone,'gender_id'=>$gender_id,'dob'=>$dob,'address'=>$address]), 'Created person');
  }
  header('Location: index.php');
  exit;
}

require '../admin_header.php';
?>
<h2 class="mb-4"><?= $id ? 'Edit' : 'Add'; ?> Person</h2>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="mb-3">
    <label class="form-label">First Name</label>
    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($first_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Last Name</label>
    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($last_name); ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Phone</label>
    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($phone); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Gender</label>
    <select name="gender_id" class="form-select">
      <option value="">-- Select --</option>
      <?php foreach($genderItems as $g): ?>
        <option value="<?= $g['id']; ?>" <?= (int)$gender_id === (int)$g['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($g['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Date of Birth</label>
    <input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($dob); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($address); ?></textarea>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require '../admin_footer.php'; ?>
