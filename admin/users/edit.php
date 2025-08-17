<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $email = '';
$type = 'USER';
$status = 1;
$btnClass = $id ? 'btn-warning' : 'btn-success';
$existing = null;

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT username, email, type, status FROM users WHERE id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $existing = $row;
    $username = $row['username'];
    $email = $row['email'];
    $type = $row['type'];
    $status = $row['status'];
  }
} else {
  require_permission('users','create');
}

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!hash_equals($token, $_POST['csrf_token'] ?? '')) {
    die('Invalid CSRF token');
  }
  $username = trim($_POST['username'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $type = $_POST['type'] === 'ADMIN' ? 'ADMIN' : 'USER';
  $status = isset($_POST['status']) ? (int)$_POST['status'] : 0;
  $password = trim($_POST['password'] ?? '');
  if ($id) {
    $old = json_encode($existing);
    $sql = 'UPDATE users SET username=:username, email=:email, type=:type, status=:status, user_updated=:uid';
    $params = [':username'=>$username, ':email'=>$email, ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id, ':id'=>$id];
    if ($password !== '') {
      $sql .= ', password=:password';
      $params[':password'] = password_hash($password, PASSWORD_DEFAULT);
    }
    $sql .= ' WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    admin_audit_log($pdo, $this_user_id, 'users', $id, 'UPDATE', $old, json_encode(['username'=>$username,'email'=>$email,'type'=>$type,'status'=>$status]), 'Updated user');
  } else {
    $stmt = $pdo->prepare('INSERT INTO users (username,email,password,type,status,user_id,user_updated) VALUES (:username,:email,:password,:type,:status,:uid,:uid)');
    $stmt->execute([':username'=>$username, ':email'=>$email, ':password'=>password_hash($password, PASSWORD_DEFAULT), ':type'=>$type, ':status'=>$status, ':uid'=>$this_user_id]);
    $id = $pdo->lastInsertId();
    admin_audit_log($pdo, $this_user_id, 'users', $id, 'CREATE', null, json_encode(['username'=>$username,'email'=>$email,'type'=>$type,'status'=>$status]), 'Created user');
  }
  header('Location: index.php?msg=' . urlencode('User saved.'));
  exit;
}
?>
<h2 class="mb-4"><?= $id ? 'Edit User' : 'Add User'; ?></h2>
<form id="userForm" method="post"></form>
<div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
  <ul class="nav justify-content-between nav-wizard nav-wizard-success">
    <li class="nav-item"><a class="nav-link active fw-semibold" href="#wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">Account</a></li>
    <li class="nav-item"><a class="nav-link fw-semibold" href="#wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">Personal</a></li>
    <li class="nav-item"><a class="nav-link fw-semibold" href="#wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">Billing</a></li>
    <li class="nav-item"><a class="nav-link fw-semibold" href="#wizard-tab4" data-bs-toggle="tab" data-wizard-step="4">Done</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" role="tabpanel" id="wizard-tab1">
      <form data-wizard-form="1">
        <input type="hidden" form="userForm" name="csrf_token" value="<?= $token; ?>">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input class="form-control" form="userForm" type="text" name="username" value="<?= htmlspecialchars($username); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input class="form-control" form="userForm" type="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password <?= $id ? '(leave blank to keep existing)' : ''; ?></label>
          <input class="form-control" form="userForm" type="password" name="password" <?= $id ? '' : 'required'; ?>>
        </div>
      </form>
    </div>
    <div class="tab-pane" role="tabpanel" id="wizard-tab2">
      <form data-wizard-form="2">
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input class="form-control" type="text" placeholder="First Name" form="userForm" name="first_name">
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input class="form-control" type="text" placeholder="Last Name" form="userForm" name="last_name">
        </div>
      </form>
    </div>
    <div class="tab-pane" role="tabpanel" id="wizard-tab3">
      <form data-wizard-form="3">
        <div class="mb-3">
          <label class="form-label">Type</label>
          <select class="form-select" form="userForm" name="type">
            <option value="USER" <?= $type==='USER' ? 'selected' : ''; ?>>User</option>
            <option value="ADMIN" <?= $type==='ADMIN' ? 'selected' : ''; ?>>Admin</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select class="form-select" form="userForm" name="status">
            <option value="1" <?= $status ? 'selected' : ''; ?>>Active</option>
            <option value="0" <?= !$status ? 'selected' : ''; ?>>Inactive</option>
          </select>
        </div>
      </form>
    </div>
    <div class="tab-pane text-center" role="tabpanel" id="wizard-tab4">
      <p class="mt-3">Review and submit to save user.</p>
    </div>
  </div>
  <div class="card-footer border-top-0 d-none" data-wizard-footer="data-wizard-footer">
    <div class="d-flex pager wizard list-inline mb-0">
      <button class="btn btn-link ps-0 d-none" type="button" data-wizard-prev-btn>Previous</button>
      <button class="btn btn-primary px-6" type="button" data-wizard-next-btn>Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"></span></button>
      <button class="btn <?= $btnClass; ?> px-6 d-none" type="submit" form="userForm" data-wizard-submit-btn>Finish</button>
    </div>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
