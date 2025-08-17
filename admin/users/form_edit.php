<?php
// Edit user form. Expects lookup arrays ($roles, $typeOptions, $statusOptions) and
// color maps ($roleColors, $typeColors, $statusColors) along with
// variables: $token, $id, $email, $first_name, $last_name,
// $type, $status, $btnClass, $assigned (array of role ids)

if (!defined('IN_APP')) {
    exit('No direct script access allowed');
}
?>

<div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
  <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
    <ul class="nav justify-content-between nav-wizard nav-wizard-success">
      <li class="nav-item"><a class="nav-link active fw-semibold" href="#user-tab1" data-bs-toggle="tab" data-wizard-step="1">
          <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Account</span></div>
        </a></li>
      <li class="nav-item"><a class="nav-link fw-semibold" href="#user-tab2" data-bs-toggle="tab" data-wizard-step="2">
          <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Details</span></div>
        </a></li>
    </ul>
  </div>
  <div class="card-body pt-4 pb-0">
    <div class="tab-content">
      <div class="tab-pane active" role="tabpanel" id="user-tab1" aria-labelledby="user-tab1">
        <form class="needs-validation" novalidate data-wizard-form="1" method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($username); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($email); ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" class="form-control" name="password">
          </div>
          <div class="mb-3">
            <label class="form-label">Roles</label>
              <?php foreach($roles as $r): $rClass = $roleColors[$r['name']] ?? 'secondary'; ?>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>" id="role<?= $r['id']; ?>" <?= in_array($r['id'], $assigned) ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="role<?= $r['id']; ?>">
                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($rClass); ?>"><span class="badge-label"><?= htmlspecialchars($r['name']); ?></span></span>
                  </label>
                </div>
              <?php endforeach; ?>
          </div>

        </form>
      </div>
      <div class="tab-pane" role="tabpanel" id="user-tab2" aria-labelledby="user-tab2">
        <form id="userWizardFinal" class="needs-validation" novalidate data-wizard-form="2" method="post">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
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
            <div>
              <?php foreach($typeOptions as $code => $label): $class = $typeColors[$code] ?? 'secondary'; ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="type" id="type<?= $code; ?>" value="<?= htmlspecialchars($code); ?>" <?= $type === $code ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="type<?= $code; ?>">
                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($class); ?>"><span class="badge-label"><?= htmlspecialchars($label); ?></span></span>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <div>
              <?php foreach($statusOptions as $code => $label): $class = $statusColors[$code] ?? 'secondary'; ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" id="status<?= $code; ?>" value="<?= htmlspecialchars($code); ?>" <?= (string)$status === (string)$code ? 'checked' : ''; ?>>
                  <label class="form-check-label" for="status<?= $code; ?>">
                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?= htmlspecialchars($class); ?>"><span class="badge-label"><?= htmlspecialchars($label); ?></span></span>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card-footer border-top-0" data-wizard-footer="data-wizard-footer">
    <div class="d-flex pager wizard list-inline mb-0">
      <button class="btn btn-link ps-0 d-none" type="button" data-wizard-prev-btn="data-wizard-prev-btn"><span class="fas fa-chevron-left me-1" data-fa-transform="shrink-3"></span>Previous</button>
      <button class="btn btn-primary px-6" type="button" data-wizard-next-btn="data-wizard-next-btn">
        Next<span class="fas fa-chevron-right ms-1" data-fa-transform="shrink-3"></span>
      </button>
      <button class="btn btn-primary px-6 d-none"
              type="submit"
              form="userWizardFinal"
              data-wizard-submit-btn="data-wizard-submit-btn">Save</button>
    </div>
  </div>
</div>
<a href="index.php" class="btn btn-secondary">Back</a>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const forms = document.querySelectorAll('[data-wizard-form]');
  if (forms.length) {
    const lastForm = forms[forms.length - 1];
    lastForm.addEventListener('submit', function () {
      lastForm.querySelectorAll('[data-wizard-cloned]').forEach(el => el.remove());
      forms.forEach(form => {
        if (form === lastForm) return;
        const fd = new FormData(form);
        fd.forEach((value, key) => {
          const esc = window.CSS && CSS.escape ? CSS.escape(key) : key.replace(/([\.\[\]\:])/g, '\\$1');
          const matches = lastForm.querySelectorAll(`[name="${esc}"]`);
          const exists = Array.from(matches).some(el => el.value === value);
          if (!exists) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            input.setAttribute('data-wizard-cloned', '1');
            lastForm.appendChild(input);
          }
        });
      });
    });
  }
});
</script>

