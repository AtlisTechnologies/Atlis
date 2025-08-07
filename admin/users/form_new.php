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
  <div class="mb-3">
    <label class="form-label">Roles</label>
    <?php foreach($roles as $r): ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="roles[]" value="<?= $r['id']; ?>" id="role<?= $r['id']; ?>" <?= in_array($r['id'], $assigned) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="role<?= $r['id']; ?>"><?= htmlspecialchars($r['name']); ?></label>
      </div>
    <?php endforeach; ?>
  </div>
  <button class="btn <?= $btnClass; ?>" type="submit">Save</button>
  <a href="index.php" class="btn btn-secondary">Back</a>
</form>
