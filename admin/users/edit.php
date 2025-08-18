<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$email = '';
$first_name = $last_name = '';
$gender_id = null;
$phone = $dob = $address = '';

$memo = [];
$profile_pic = '';

$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT u.email, u.profile_pic, u.memo, p.first_name, p.last_name, p.gender_id, p.phone, p.dob, p.address FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $email = $row['email'];
    $profile_pic = $row['profile_pic'];
    $memo = json_decode($row['memo'] ?? '{}', true);
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
    $gender_id = $row['gender_id'] ?? null;
    $phone = $row['phone'] ?? '';
    $dob = $row['dob'] ?? '';
    $address = $row['address'] ?? '';
  }
} else {
  require_permission('users','create');
}

$genderItems = get_lookup_items($pdo, 'USER_GENDER');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

?>
<?php if ($errors): ?>
  <div class="alert alert-danger">
    <ul class="mb-0">
      <?php foreach ($errors as $e): ?>
        <li><?php echo htmlspecialchars($e); ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>
<h2 class="mb-4"><?php echo $id ? 'Edit' : 'Create'; ?> User</h2>
<form action="functions/save.php" method="post" enctype="multipart/form-data" class="card theme-wizard" data-theme-wizard="data-theme-wizard">
  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  <?php if ($id): ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  <?php endif; ?>
  <div class="card-header bg-body-tertiary pt-3 pb-2">
    <ul class="nav justify-content-between nav-wizard">
      <li class="nav-item"><a class="nav-link active fw-semibold" href="#tab-account" data-bs-toggle="tab" data-wizard-step="1"><div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Account</span></div></a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#tab-personal" data-bs-toggle="tab" data-wizard-step="2"><div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Personal</span></div></a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#tab-done" data-bs-toggle="tab" data-wizard-step="3"><div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-check"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Done</span></div></a></li>
    </ul>
  </div>
  <div class="card-body pt-4 pb-0">
    <div class="tab-content">
      <div class="tab-pane active" id="tab-account" role="tabpanel">
        <div class="row g-3 mb-3">
          <div class="col-sm-6">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($first_name); ?>" required>
          </div>
          <div class="col-sm-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($last_name); ?>" required>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-sm-6">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" <?php echo $id ? '' : 'required'; ?>>
          </div>
          <div class="col-sm-6">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirmPassword" class="form-control" <?php echo $id ? '' : 'required'; ?>>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="tab-personal" role="tabpanel">
        <div class="mb-3">
          <label class="form-label">Profile Picture</label>
          <?php if ($profile_pic): ?>
            <div class="mb-2"><img src="/<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="img-thumbnail" style="max-width:150px;"></div>
          <?php endif; ?>
          <input type="file" name="profile_pic" accept="image/png,image/jpeg" class="form-control">
        </div>
        <div class="mb-3">
          <label class="form-label">Gender</label>
          <select name="gender_id" class="form-select">
            <option value="">Select...</option>
            <?php foreach ($genderItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php echo (int)$gender_id === (int)$item['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Phone</label>
          <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Date of Birth</label>
          <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($dob); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Address</label>
          <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($address); ?></textarea>
        </div>
      </div>
      <div class="tab-pane" id="tab-done" role="tabpanel">
        <div class="text-center py-4">
          <h4>All set!</h4>
          <p>Click submit to save this user.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
    <div class="d-flex pager wizard list-inline mb-0">
      <button class="d-none btn btn-link ps-0" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Previous</button>
      <div class="flex-1 text-end">
        <button class="btn btn-success px-6 px-sm-6" type="submit" data-wizard-next-btn="data-wizard-next-btn">Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"></span></button>
      </div>
    </div>
  </div>
</form>

<?php require '../admin_footer.php'; ?>
