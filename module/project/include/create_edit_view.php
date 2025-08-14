<?php
// Create or edit project form
$editing = !empty($current_project);
$actionUrl = $editing ? 'functions/update.php' : 'functions/create.php';
?>
<form method="post" action="<?php echo $actionUrl; ?>">
  <?php if ($editing): ?>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($current_project['id']); ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($current_project['name'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php foreach ($statusMap as $id => $status): ?>
        <option value="<?php echo htmlspecialchars($id); ?>" <?php if (($current_project['status'] ?? '') == $id) echo 'selected'; ?>><?php echo htmlspecialchars($status['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($current_project['description'] ?? ''); ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><?php echo $editing ? 'Update' : 'Create'; ?></button>
</form>

