<?php
// Form for creating/editing tasks
?>
<form method="post" action="index.php?action=save">
  <input type="hidden" name="id" value="<?php echo h($task['id'] ?? ''); ?>">
  <div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" class="form-control" value="<?php echo h($task['name'] ?? ''); ?>" required>
  </div>
  <div class="row">
    <div class="mb-3 col-md-4">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <?php foreach ($statusMap as $s): ?>
          <option value="<?php echo $s['id']; ?>" <?php if (($task['status'] ?? '') == $s['id']) echo 'selected'; ?>><?php echo h($s['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3 col-md-4">
      <label class="form-label">Priority</label>
      <select name="priority" class="form-select">
        <?php foreach ($priorityMap as $p): ?>
          <option value="<?php echo $p['id']; ?>" <?php if (($task['priority'] ?? '') == $p['id']) echo 'selected'; ?>><?php echo h($p['label']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3 col-md-4">
      <label class="form-label">Project</label>
      <select name="project_id" class="form-select">
        <option value="">-- None --</option>
        <?php foreach ($projects as $p): ?>
          <option value="<?php echo $p['id']; ?>" <?php if (($task['project_id'] ?? '') == $p['id']) echo 'selected'; ?>><?php echo h($p['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="mb-3 col-md-6">
      <label class="form-label">Agency</label>
      <select name="agency_id" class="form-select">
        <option value="">-- None --</option>
        <?php foreach ($agencies as $a): ?>
          <option value="<?php echo $a['id']; ?>" <?php if (($task['agency_id'] ?? '') == $a['id']) echo 'selected'; ?>><?php echo h($a['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3 col-md-6">
      <label class="form-label">Division</label>
      <select name="division_id" class="form-select">
        <option value="">-- None --</option>
        <?php foreach ($divisions as $d): ?>
          <option value="<?php echo $d['id']; ?>" <?php if (($task['division_id'] ?? '') == $d['id']) echo 'selected'; ?>><?php echo h($d['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mb-3">
    <label class="form-label">Assigned Users</label>
    <select name="assigned_users[]" multiple class="form-select">
      <?php foreach ($users as $u): ?>
        <option value="<?php echo $u['id']; ?>" <?php if (in_array($u['id'], $assignedUsers)) echo 'selected'; ?>><?php echo h($u['email']); ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <button type="submit" class="btn btn-success">Save</button>
</form>
