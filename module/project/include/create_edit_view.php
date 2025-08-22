<?php
// Create or edit project form
require_once __DIR__ . '/../../../includes/functions.php';
$editing = !empty($current_project);
$actionUrl = $editing ? 'functions/update.php' : 'functions/create.php';
$defaultTypeId = '';
foreach ($typeMap as $id => $t) {
  if (!empty($t['is_default'])) {
    $defaultTypeId = $id;
    break;
  }
}
?>
<form class="row g-3 mb-6" method="post" action="<?php echo $actionUrl; ?>">
  <?php if ($editing): ?>
    <input type="hidden" name="id" value="<?php echo h($current_project['id'] ?? ''); ?>">
  <?php endif; ?>
  <div class="col-12">
    <div class="form-floating">
      <input class="form-control" id="projectName" type="text" name="name" placeholder="Project title" value="<?php echo h($current_project['name'] ?? ''); ?>" required>
      <label for="projectName">Project title</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <select class="form-select" id="projectStatus" name="status">
        <?php foreach ($statusMap as $id => $status): ?>
          <option value="<?php echo h($id); ?>" <?php if (($current_project['status'] ?? '') == $id) echo 'selected'; ?>><?php echo h($status['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="projectStatus">Status</label>
    </div>
  </div>
  <div class="col-12">
    <div class="form-floating">
      <select class="form-select" id="projectType" name="type">
        <option value="" <?php echo $defaultTypeId ? '' : 'selected'; ?>>Select type</option>
        <?php foreach ($typeMap as $id => $type): ?>
          <option value="<?php echo h($id); ?>" <?php
            echo ($editing ? (($current_project['type'] ?? '') == $id) : ($defaultTypeId == $id)) ? 'selected' : '';
          ?>><?php echo h($type['label']); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="projectType">Type</label>
    </div>
  </div>
  <div class="col-12 gy-3">
    <div class="form-floating">
      <textarea class="form-control" id="projectDescription" name="description" placeholder="Description" style="height:100px"><?php echo h($current_project['description'] ?? ''); ?></textarea>
      <label for="projectDescription">Description</label>
    </div>
  </div>
  <div class="col-12 gy-6">
    <button type="submit" class="btn <?php echo $editing ? 'btn-atlis' : 'btn-success'; ?>"><?php echo $editing ? 'Update' : 'Create'; ?></button>
  </div>
</form>
