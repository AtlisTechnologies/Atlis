<?php
// New user form. Expects lookup arrays ($roles, $typeOptions, $statusOptions) and
// variables: $token, $username, $email, $first_name, $last_name,
// $type, $status, $btnClass, $assigned (array of role ids)

if (!defined('IN_APP')) {
    exit('No direct script access allowed');
}
?>
<form method="post">
  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
  <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
    <ul class="nav justify-content-between nav-wizard nav-wizard-success">
      <li class="nav-item"><a class="nav-link active fw-semibold" href="#user-tab1" data-bs-toggle="tab" data-wizard-step="1">Account</a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#user-tab2" data-bs-toggle="tab" data-wizard-step="2">Details</a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#user-tab3" data-bs-toggle="tab" data-wizard-step="3">Roles</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" role="tabpanel" id="user-tab1" aria-labelledby="user-tab1">
        <div class="mb-3">
          <label class="form-label">Username</label>
          <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($username); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email); ?>" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
      </div>
      <div class="tab-pane" role="tabpanel" id="user-tab2" aria-labelledby="user-tab2">
        <div class="mb-3">
          <label class="form-label">First Name</label>
          <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($first_name); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Last Name</label>
          <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($last_name); ?>">
        </div>
        <div class="mb-3">
          <label class="form-label">Type</label>
          <select class="form-select" name="type">
            <?php foreach($typeOptions as $value => $label): ?>
              <option value="<?= htmlspecialchars($value); ?>" <?= $type === $value ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select class="form-select" name="status">
            <?php foreach($statusOptions as $value => $label): ?>
              <option value="<?= htmlspecialchars($value); ?>" <?= (string)$status === $value ? 'selected' : ''; ?>><?= htmlspecialchars($label); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="tab-pane" role="tabpanel" id="user-tab3" aria-labelledby="user-tab3">
        <div class="mb-3">
          <label class="form-label">Roles</label>
          <?php foreach($roles as $r): ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>" id="role<?= $r['id']; ?>" <?= in_array($r['id'], $assigned) ? 'checked' : ''; ?>>
              <label class="form-check-label" for="role<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?></label>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
      <div class="d-flex pager wizard list-inline mb-0">
        <button class="d-none btn btn-link ps-0" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Previous</button>
        <button class="btn btn-primary px-6" type="button" data-wizard-next-btn="data-wizard-next-btn">Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"></span></button>
        <button class="btn <?= $btnClass; ?> d-none ms-auto" type="submit" data-wizard-submit-btn="data-wizard-submit-btn">Save</button>
      </div>
    </div>
  </div>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
