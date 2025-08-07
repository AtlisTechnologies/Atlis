<?php
// Shared customer form fields: expects $name, $main_person, $status, $statuses arrays defined
?>
<div class="mb-3">
  <label class="form-label">Name</label>
  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name); ?>" required>
</div>
<div class="mb-3">
  <label class="form-label">Main Person ID</label>
  <input type="number" name="main_person" class="form-control" value="<?= htmlspecialchars($main_person); ?>">
</div>
<div class="mb-3">
  <label class="form-label">Status</label>
  <select name="status" class="form-select">
    <option value="">--</option>
    <?php foreach($statuses as $s): ?>
      <option value="<?= $s['id']; ?>" <?= (string)$status === (string)$s['id'] ? 'selected' : ''; ?>><?= htmlspecialchars($s['label']); ?></option>
    <?php endforeach; ?>
  </select>
</div>
