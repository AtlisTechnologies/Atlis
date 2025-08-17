<?php
require '../admin_header.php';

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
  <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
    <ul class="nav justify-content-between nav-wizard nav-wizard-success">
      <li class="nav-item"><a class="nav-link active fw-semibold" href="#user-account-tab" data-bs-toggle="tab" data-wizard-step="1">
            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Account</span></div>
          </a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#user-personal-tab" data-bs-toggle="tab" data-wizard-step="2">
            <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Personal</span></div>
          </a></li>
    </ul>
  </div>
  <div class="card-body pt-4 pb-0">
    <div class="tab-content">
      <div class="tab-pane active" id="user-account-tab" role="tabpanel" aria-labelledby="user-account-tab">
        <form class="needs-validation" novalidate data-wizard-form="1">
          <div class="mb-3">
            <label class="form-label" for="user-username">Username</label>
            <input class="form-control" id="user-username" type="text" name="username" required>
            <div class="invalid-feedback">Username is required.</div>
          </div>
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="form-label" for="user-password">Password</label>
              <input class="form-control" id="user-password" type="password" data-wizard-password required>
              <div class="invalid-feedback">Password is required.</div>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="user-confirm-password">Confirm Password</label>
              <input class="form-control" id="user-confirm-password" type="password" data-wizard-confirm-password required>
              <div class="invalid-feedback">Passwords need to match.</div>
            </div>
          </div>
        </form>
      </div>
      <div class="tab-pane" id="user-personal-tab" role="tabpanel" aria-labelledby="user-personal-tab">
        <form class="needs-validation" method="post" novalidate data-wizard-form="2">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <div class="mb-3">
            <label class="form-label" for="user-first-name">First Name</label>
            <input class="form-control" id="user-first-name" type="text" name="first_name" required>
            <div class="invalid-feedback">First name is required.</div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="user-last-name">Last Name</label>
            <input class="form-control" id="user-last-name" type="text" name="last_name" required>
            <div class="invalid-feedback">Last name is required.</div>

          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
    <button class="btn btn-link ps-0 d-none" type="button" data-wizard-prev-btn></button>
    <button class="btn btn-primary px-6" type="button" data-wizard-next-btn></button>
    <button class="btn btn-primary px-6 d-none" type="submit" data-wizard-submit-btn>Save</button>
  </div>
</div>

<?php require '../admin_footer.php'; ?>
