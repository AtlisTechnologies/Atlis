<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$email = '';
$first_name = $last_name = '';
$gender_id = null;
$phone = $dob = $address = '';

$memo = [];
$profile_pic = '';
$profilePics = [];

$errors = $_SESSION['form_errors'] ?? [];
unset($_SESSION['form_errors']);

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT u.email, u.current_profile_pic_id, u.memo, p.first_name, p.last_name, p.gender_id, p.phone, p.dob, p.address, up.file_path AS profile_path FROM users u LEFT JOIN person p ON u.id = p.user_id LEFT JOIN users_profile_pics up ON u.current_profile_pic_id = up.id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $email = $row['email'];
    $profile_pic = $row['profile_path'];
    $memo = json_decode($row['memo'] ?? '{}', true);
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
    $gender_id = $row['gender_id'] ?? null;
    $phone = $row['phone'] ?? '';
    $dob = $row['dob'] ?? '';
    $address = $row['address'] ?? '';

    $picStmt = $pdo->prepare('SELECT up.id, up.file_path, up.width, up.height, up.status_id, up.date_created, li.label AS status_label, li.code AS status_code FROM users_profile_pics up LEFT JOIN lookup_list_items li ON up.status_id = li.id WHERE up.user_id = :uid ORDER BY up.date_created DESC');
    $picStmt->execute([':uid' => $id]);
    $profilePics = $picStmt->fetchAll(PDO::FETCH_ASSOC);
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
            <div class="mb-2"><img src="<?php echo getURLDir(); echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="img-thumbnail" style="max-width:150px;"></div>
          <?php endif; ?>
          <input type="file" name="profile_pic" accept="image/png,image/jpeg" class="form-control">
        </div>
        <?php if ($id && $profilePics): ?>
        <div class="mb-3">
          <div class="accordion" id="profilePicAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingPics">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePics" aria-expanded="false" aria-controls="collapsePics">Previous Profile Pictures</button>
              </h2>
              <div id="collapsePics" class="accordion-collapse collapse" data-bs-parent="#profilePicAccordion">
                <div class="accordion-body p-0">
                  <table class="table mb-0">
                    <thead>
                      <tr>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Dimensions</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($profilePics as $pic): ?>
                        <tr>
                          <td><img src="<?php echo getURLDir(); echo htmlspecialchars($pic['file_path']); ?>" class="img-thumbnail" style="width:60px;height:auto;"></td>
                          <td><?php echo htmlspecialchars($pic['status_label']); ?></td>
                          <td><?php echo htmlspecialchars($pic['date_created']); ?></td>
                          <td><?php echo htmlspecialchars($pic['width']); ?>x<?php echo htmlspecialchars($pic['height']); ?></td>
                          <td>
                            <?php if ($pic['status_code'] !== 'ACTIVE'): ?>
                              <form method="post" action="functions/save.php" class="d-inline reactivate-form">
                                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="hidden" name="reactivate_pic_id" value="<?php echo $pic['id']; ?>">
                                <input type="hidden" name="gender_id" value="<?php echo htmlspecialchars($gender_id ?? ''); ?>">
                                <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                                <input type="hidden" name="dob" value="<?php echo htmlspecialchars($dob); ?>">
                                <input type="hidden" name="address" value="<?php echo htmlspecialchars($address); ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Reactivate</button>
                              </form>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>
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
        <button class="btn btn-success px-6 px-sm-6" type="button" data-wizard-next-btn="data-wizard-next-btn">Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"></span></button>
        <button class="btn btn-success px-6 px-sm-6 d-none" type="submit" data-wizard-submit-btn="data-wizard-submit-btn">Save</button>
      </div>
    </div>
  </div>
</form>

<script>
document.querySelectorAll('.reactivate-form').forEach(function(form){
  form.addEventListener('submit', function(){
    var gender = document.querySelector('select[name="gender_id"]');
    var phone = document.querySelector('input[name="phone"]');
    var dob = document.querySelector('input[name="dob"]');
    var address = document.querySelector('textarea[name="address"]');
    if (gender) form.querySelector('input[name="gender_id"]').value = gender.value;
    if (phone) form.querySelector('input[name="phone"]').value = phone.value;
    if (dob) form.querySelector('input[name="dob"]').value = dob.value;
    if (address) form.querySelector('input[name="address"]').value = address.value;
  });
});
</script>

<?php require '../admin_footer.php'; ?>
