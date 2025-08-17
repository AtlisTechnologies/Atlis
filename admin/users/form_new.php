<?php
require '../admin_header.php';
?>
<h2 class="mb-4">Add User</h2>
<div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane active" id="step1" role="tabpanel">
        <form id="wizardForm1" data-wizard-form="1">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control">
          </div>
        </form>
      </div>
      <div class="tab-pane" id="step2" role="tabpanel">
        <form id="wizardForm2" data-wizard-form="2">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <form id="finalForm" method="post" action="new.php">
      <button type="button" id="saveBtn" class="btn btn-success">Save</button>
    </form>
  </div>
</div>
<script>
document.getElementById('saveBtn').addEventListener('click', function(){
  const finalForm = document.getElementById('finalForm');
  finalForm.querySelectorAll('input[type="hidden"]').forEach(el => el.remove());
  document.querySelectorAll('[data-wizard-form]').forEach(form => {
    const fd = new FormData(form);
    for (const [key, value] of fd.entries()) {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = key;
      input.value = value;
      finalForm.appendChild(input);
    }
  });
  finalForm.submit();
});
</script>
<?php require '../admin_footer.php'; ?>
