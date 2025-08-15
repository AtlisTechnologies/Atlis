<?php
// Create or edit task form
$editing = !empty($current_task);
$actionUrl = $editing ? 'functions/update.php' : 'functions/create.php';
?>
<form method="post" action="<?php echo $actionUrl; ?>">
  <?php if ($editing): ?>
    <input type="hidden" name="id" value="<?php echo h($current_task['id']); ?>">
  <?php endif; ?>
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?php echo h($current_task['name'] ?? ''); ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <?php foreach ($statusMap as $id => $status): ?>
        <option value="<?php echo h($id); ?>" <?php if (($current_task['status'] ?? '') == $id) echo 'selected'; ?>><?php echo h($status['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Priority</label>
    <select name="priority" class="form-select">
      <?php foreach ($priorityMap as $id => $priority): ?>
        <option value="<?php echo h($id); ?>" <?php if (($current_task['priority'] ?? '') == $id) echo 'selected'; ?>><?php echo h($priority['label']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4"><?php echo h($current_task['description'] ?? ''); ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><?php echo $editing ? 'Update' : 'Create'; ?></button>
</form>

