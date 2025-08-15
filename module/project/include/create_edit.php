<?php
require_once __DIR__ . '/../../../includes/functions.php';

$editing    = !empty($current_project);
$actionUrl  = $editing ? 'functions/update.php' : 'functions/create.php';
$permAction = $editing ? 'update' : 'create';
require_permission('project', $permAction);
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $editing ? 'Edit' : 'Create'; ?></li>
  </ol>
</nav>
<h2 class="mb-4"><?php echo $editing ? 'Edit project' : 'Create a project'; ?></h2>
<div class="row">
  <div class="col-xl-9">
    <form class="row g-3 mb-6" method="post" action="<?php echo $actionUrl; ?>">
      <?php if ($editing): ?>
      <input type="hidden" name="id" value="<?php echo h($current_project['id']); ?>">
      <?php endif; ?>
      <div class="col-sm-6 col-md-8">
        <div class="form-floating">
          <input class="form-control" id="projectName" type="text" name="name" placeholder="Project title" value="<?php echo h($current_project['name'] ?? ''); ?>" required />
          <label for="projectName">Project title</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="projectStatus" name="status" required>
            <?php foreach ($statusMap as $id => $s): ?>
              <option value="<?php echo h($s['id'] ?? $id); ?>" <?php if (($current_project['status'] ?? '') == ($s['id'] ?? $id)) echo 'selected'; ?>><?php echo h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="projectStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="startDate" type="text" name="start_date" placeholder="start date" data-options='{"disableMobile":true}' value="<?php echo h($current_project['start_date'] ?? ''); ?>" />
            <label class="ps-6" for="startDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="agencySelect" name="agency_id">
            <option value="">Select agency</option>
            <?php foreach ($agencies as $agency): ?>
              <option value="<?php echo h($agency['id']); ?>" <?php if (($current_project['agency_id'] ?? '') == $agency['id']) echo 'selected'; ?>><?php echo h($agency['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="agencySelect">Agency</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="divisionSelect" name="division_id">
            <option value="">Select division</option>
            <?php foreach ($divisions as $division): ?>
              <option value="<?php echo h($division['id']); ?>" <?php if (($current_project['division_id'] ?? '') == $division['id']) echo 'selected'; ?>><?php echo h($division['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="divisionSelect">Division</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectDescription" name="description" placeholder="Leave a description here" style="height:100px"><?php echo h($current_project['description'] ?? ''); ?></textarea>
          <label for="projectDescription">Project description</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectRequirements" name="requirements" placeholder="Requirements" style="height:100px"><?php echo h($current_project['requirements'] ?? ''); ?></textarea>
          <label for="projectRequirements">Requirements</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectSpecifications" name="specifications" placeholder="Specifications" style="height:100px"><?php echo h($current_project['specifications'] ?? ''); ?></textarea>
          <label for="projectSpecifications">Specifications</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="row g-3 justify-content-end">
          <div class="col-auto">
            <a class="btn btn-warning px-5" href="<?php echo $editing ? 'index.php?action=details&id=' . (int)$current_project['id'] : 'index.php'; ?>">Cancel</a>
          </div>
          <div class="col-auto">
            <button class="btn atlis px-5 px-sm-15" type="submit"><?php echo $editing ? 'Update Project' : 'Create Project'; ?></button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
