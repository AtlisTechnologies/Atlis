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
<form action="functions/save.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
  <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
  <?php if ($id): ?>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  <?php endif; ?>
  <div class="border-bottom border-translucent mb-4">
    <div class="d-sm-flex justify-content-between">
      <h2 class="mb-0"><?php echo $id ? 'Edit' : 'Create'; ?> User</h2>
      <div class="d-flex mb-2">
        <a class="btn btn-phoenix-primary me-2 px-6" href="index.php">Cancel</a>
        <button class="btn btn-primary px-6" type="submit"><?php echo $id ? 'Save' : 'Create'; ?></button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-9">
      <div class="d-flex align-items-end position-relative mb-4">
        <input class="d-none" id="upload-avatar" type="file" name="profile_pic" accept="image/png,image/jpeg" />
        <div class="hoverbox" style="width: 150px; height: 150px">
          <div class="hoverbox-content rounded-circle d-flex flex-center z-1" style="--phoenix-bg-opacity:.56;"><span class="fa-solid fa-camera fs-1 text-body-quaternary"></span></div>
          <div class="position-relative bg-body-quaternary rounded-circle cursor-pointer d-flex flex-center">
            <div class="avatar avatar-5xl"><img class="rounded-circle" src="<?php echo $profile_pic ? getURLDir() . htmlspecialchars($profile_pic) : getURLDir() . 'assets/img/team/150x150/58.webp'; ?>" alt="" /></div>
            <label class="w-100 h-100 position-absolute z-1" for="upload-avatar"></label>
          </div>
        </div>
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
      <div class="row g-3 mb-3">
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($first_name); ?>" required>
            <label for="first_name">First Name</label>
            <div class="invalid-feedback">Please provide a first name.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($last_name); ?>" required>
            <label for="last_name">Last Name</label>
            <div class="invalid-feedback">Please provide a last name.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <label for="email">Email</label>
            <div class="invalid-feedback">Please provide a valid email.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" <?php echo $id ? '' : 'required'; ?>>
            <label for="password">Password</label>
            <div class="invalid-feedback">Please provide a password.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" <?php echo $id ? '' : 'required'; ?>>
            <label for="confirmPassword">Confirm Password</label>
            <div class="invalid-feedback">Please confirm password.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="gender_id" name="gender_id">
              <option value="">Select...</option>
              <?php foreach ($genderItems as $item): ?>
                <option value="<?php echo $item['id']; ?>" <?php echo (int)$gender_id === (int)$item['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($item['label']); ?></option>
              <?php endforeach; ?>
            </select>
            <label for="gender_id">Gender</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo htmlspecialchars($phone); ?>">
            <label for="phone">Phone</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo htmlspecialchars($dob); ?>">
            <label for="dob">Date of Birth</label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating">
            <textarea class="form-control" id="address" name="address" placeholder="Address" style="height:100px"><?php echo htmlspecialchars($address); ?></textarea>
            <label for="address">Address</label>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<script>
(function () {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})();

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
