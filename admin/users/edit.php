<?php
require '../admin_header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$email = '';
$first_name = $last_name = '';
$gender_id = null;
$dob = '';
$addresses = [];
$phones = [];

$roles = [];
$userRoleIds = [];

$memo = [];
$profile_pic = '';
$profilePics = [];

$defaultPassword = '';

$errors = $_SESSION['form_errors'] ?? [];
if (!empty($_SESSION['error_message'])) {
  $errors[] = $_SESSION['error_message'];
}
unset($_SESSION['form_errors'], $_SESSION['error_message']);

if ($id) {
  require_permission('users','update');
  $stmt = $pdo->prepare('SELECT u.email, u.current_profile_pic_id, u.memo, p.id AS person_id, p.first_name, p.last_name, p.gender_id, p.dob, up.file_path AS profile_path FROM users u LEFT JOIN person p ON u.id = p.user_id LEFT JOIN users_profile_pics up ON u.current_profile_pic_id = up.id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $email = $row['email'];
    $profile_pic = $row['profile_path'];
    $memo = json_decode($row['memo'] ?? '{}', true);
    $first_name = $row['first_name'] ?? '';
    $last_name = $row['last_name'] ?? '';
    $gender_id = $row['gender_id'] ?? null;
    $dob = $row['dob'] ?? '';
    $person_id = $row['person_id'] ?? null;

    if ($person_id) {
      $stmt = $pdo->prepare('SELECT * FROM person_addresses WHERE person_id = :pid');
      $stmt->execute([':pid' => $person_id]);
      $addresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $stmt = $pdo->prepare('SELECT * FROM person_phones WHERE person_id = :pid');
      $stmt->execute([':pid' => $person_id]);
      $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    $picStmt = $pdo->prepare('SELECT up.id, up.file_path, up.width, up.height, up.status_id, up.date_created, li.label AS status_label, li.code AS status_code FROM users_profile_pics up LEFT JOIN lookup_list_items li ON up.status_id = li.id WHERE up.user_id = :uid ORDER BY up.date_created DESC');
    $picStmt->execute([':uid' => $id]);
    $profilePics = $picStmt->fetchAll(PDO::FETCH_ASSOC);
  }
} else {
  require_permission('users','create');
  $defaultPassword = get_system_property($pdo, 'USER_DEFAULT_PASSWORD') ?? '';
}

$roles = $pdo->query('SELECT id, name FROM admin_roles ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
if ($id) {
  $stmt = $pdo->prepare('SELECT role_id FROM admin_user_roles WHERE user_account_id = :uid');
  $stmt->execute([':uid' => $id]);
  $userRoleIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$imageTypes = get_lookup_items($pdo, 'IMAGE_FILE_TYPES');
$genderItems = get_lookup_items($pdo, 'USER_GENDER');
$addressTypeItems   = get_lookup_items($pdo, 'PERSON_ADDRESS_TYPE');
$addressStatusItems = get_lookup_items($pdo, 'PERSON_ADDRESS_STATUS');
$stateItems         = get_lookup_items($pdo, 'US_STATES');
$phoneTypeItems     = get_lookup_items($pdo, 'PERSON_PHONE_TYPE');
$phoneStatusItems   = get_lookup_items($pdo, 'PERSON_PHONE_STATUS');

function get_default_id(array $items) {
  foreach ($items as $i) { if (!empty($i['is_default'])) return $i['id']; }
  return null;
}
$defaultAddressTypeId   = get_default_id($addressTypeItems);
$defaultAddressStatusId = get_default_id($addressStatusItems);
$defaultPhoneTypeId     = get_default_id($phoneTypeItems);
$defaultPhoneStatusId   = get_default_id($phoneStatusItems);

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
    </div>
  </div>
  <div class="row">
    <div class="col-xl-9">
      <div class="d-flex align-items-end position-relative mb-4">
        <input class="d-none" id="upload-avatar" type="file" name="profile_pic" accept="<?= implode(',', array_column($imageTypes, 'code')) ?>" />
        <div class="hoverbox" style="width: 150px; height: 150px">
          <div class="hoverbox-content rounded-circle d-flex flex-center z-1" style="--phoenix-bg-opacity:.56;"><span class="fa-solid fa-camera fs-1 text-body-quaternary"></span></div>
          <div class="position-relative bg-body-quaternary rounded-circle cursor-pointer d-flex flex-center">
            <div class="avatar avatar-5xl"><img class="rounded-circle" src="<?php echo $profile_pic ? getURLDir() . htmlspecialchars($profile_pic) : getURLDir() . 'assets/img/team/150x150/58.webp'; ?>" alt="" /></div>
            <label class="w-100 h-100 position-absolute z-1" for="upload-avatar"></label>
          </div>
        </div>
      </div>
      <?php if ($imageTypes): ?>
        <div class="text-body-tertiary small mb-3">Allowed formats: <?= implode(', ', array_column($imageTypes, 'label')); ?></div>
      <?php endif; ?>
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
                        <td><img src="<?php echo getURLDir(); echo htmlspecialchars($pic['file_path'] ?? ''); ?>" class="img-thumbnail" style="width:60px;height:auto;"></td>
                        <td><?php echo htmlspecialchars($pic['status_label'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($pic['date_created'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($pic['width'] ?? ''); ?>x<?php echo htmlspecialchars($pic['height'] ?? ''); ?></td>
                        <td>
                          <?php if ($pic['status_code'] !== 'ACTIVE'): ?>
                            <button type="submit" class="btn btn-sm btn-primary" form="reactivate-form" name="reactivate_pic_id" value="<?php echo $pic['id']; ?>" formnovalidate>Reactivate</button>
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
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo htmlspecialchars($defaultPassword); ?>" <?php echo $id ? '' : 'required'; ?>>
            <label for="password">Password</label>
            <div class="invalid-feedback">Please provide a password.</div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" value="<?php echo htmlspecialchars($defaultPassword); ?>" <?php echo $id ? '' : 'required'; ?>>
            <label for="confirmPassword">Confirm Password</label>
            <div class="invalid-feedback">Please confirm password.</div>
          </div>
        </div>
        <div class="col-12">
          <h5>Roles</h5>
          <?php foreach ($roles as $r): ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>"
                     id="role_<?= $r['id']; ?>" <?= in_array($r['id'], $userRoleIds) ? 'checked' : ''; ?>>
              <label for="role_<?= $r['id']; ?>"><?= h($r['name']); ?></label>
            </div>
          <?php endforeach; ?>
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
            <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" value="<?php echo htmlspecialchars($dob); ?>">
            <label for="dob">Date of Birth</label>
          </div>
        </div>
        <div class="col-12">
          <h5 class="mt-4">Phone Numbers</h5>
          <div id="phones-container">
            <?php foreach ($phones as $i => $ph) { $index = $i; $phRow = $ph; include __DIR__.'/../../includes/person_phone_row.php'; } ?>
          </div>
          <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-phone">Add Phone</button>
        </div>
        <div class="col-12">
          <h5>Addresses</h5>
          <div id="addresses-container">
            <?php foreach ($addresses as $i => $addr) { $index = $i; $addrRow = $addr; include __DIR__.'/../../includes/person_address_row.php'; } ?>
          </div>
          <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-address">Add Address</button>
        </div>
        <center>
          <div class="d-flex mb-2">
            <a class="btn btn-outline-warning me-2 px-6" href="index.php">Cancel</a>
            <button class="btn btn-atlis px-6" type="submit"><?php echo $id ? 'Save' : 'Create'; ?></button>
          </div>
        </center>
  </div>
  </div>
  </div>
</form>
<?php if ($id && $profilePics): ?>
  <form id="reactivate-form" method="post" action="functions/save.php" class="d-none">
    <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
  </form>
<?php endif; ?>
<template id="phone-template">
<?php $index='__INDEX__'; $phRow=[]; include __DIR__.'/../../includes/person_phone_row.php'; ?>
</template>
<template id="address-template">
<?php $index='__INDEX__'; $addrRow=[]; include __DIR__.'/../../includes/person_address_row.php'; ?>
</template>
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

document.addEventListener('DOMContentLoaded', function () {
  var uploadInput = document.getElementById('upload-avatar');
  var userIdInput = document.querySelector('input[name="id"]');
  var csrfInput = document.querySelector('input[name="csrf_token"]');
  var previewImg = document.querySelector('.avatar.avatar-5xl img');
  var baseURL = '<?php echo getURLDir(); ?>';
  if (uploadInput && userIdInput && csrfInput && previewImg) {
    uploadInput.addEventListener('change', function () {
      if (!this.files.length) { return; }
      var fd = new FormData();
      fd.append('profile_pic', this.files[0]);
      fd.append('id', userIdInput.value);
      fd.append('csrf_token', csrfInput.value);
      fetch('functions/upload_pic.php', {
        method: 'POST',
        body: fd
      }).then(function(r){ return r.json(); })
        .then(function(data){
          if(data.success && data.path){
            previewImg.src = baseURL + data.path + '?t=' + Date.now();
          } else {
            alert(data.error || 'Upload failed');
          }
          uploadInput.value = '';
        }).catch(function(){
          alert('Upload failed');
          uploadInput.value = '';
        });
    });
  }
});
</script>

<script src="<?php echo getURLDir(); ?>assets/js/person_contact_rows.js"></script>

<?php require '../admin_footer.php'; ?>
