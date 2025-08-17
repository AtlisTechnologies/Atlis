<?php
require '../admin_header.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$username = $email = $first_name = $last_name = '';
if ($id) {
  $stmt = $pdo->prepare('SELECT u.username, u.email, p.first_name, p.last_name FROM users u LEFT JOIN person p ON u.id = p.user_id WHERE u.id = :id');
  $stmt->execute([':id' => $id]);
  if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $username = $row['username'];
    $email = $row['email'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
  }
}
?>
<h2 class="mb-4">Edit User</h2>
<div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane active" id="step1" role="tabpanel">
        <form id="wizardForm1" data-wizard-form="1">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?=h($username)?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?=h($email)?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password (leave blank to keep)</label>
            <input type="password" name="password" class="form-control">
          </div>
        </form>
      </div>
      <div class="tab-pane" id="step2" role="tabpanel">
        <form id="wizardForm2" data-wizard-form="2">
          <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="<?=h($first_name)?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="<?=h($last_name)?>" required>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card-footer">
    <form id="finalForm" method="post" action="edit.php?id=<?=$id?>">
      <button type="button" id="saveBtn" class="btn btn-warning">Save</button>
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
