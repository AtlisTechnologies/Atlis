<?php
// Form for creating or editing tasks using Phoenix layout
?>
<?php $isEdit = !empty($task['id']); ?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Tasks</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $isEdit ? 'Edit' : 'Create'; ?></li>
  </ol>
</nav>
<h2 class="mb-4"><?php echo $isEdit ? 'Edit Task' : 'Create Task'; ?></h2>
<div class="row">
  <div class="col-xl-9">
    <form class="row g-3 mb-6" method="post" action="index.php?action=save">
      <input type="hidden" name="id" value="<?php echo h($task['id'] ?? ''); ?>">
      <div class="col-12">
        <div class="form-floating">
          <input class="form-control" id="taskName" type="text" name="name" placeholder="Task name" value="<?php echo h($task['name'] ?? ''); ?>" required>
          <label for="taskName">Task name</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskStatus" name="status" required>
            <?php foreach ($statusMap as $s): ?>
              <option value="<?php echo $s['id']; ?>" data-color="<?php echo h($s['color_class']); ?>" <?php if (($task['status'] ?? '') == $s['id']) echo 'selected'; ?>><?php echo h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="taskStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskPriority" name="priority" required>
            <?php foreach ($priorityMap as $p): ?>
              <option value="<?php echo $p['id']; ?>" data-color="<?php echo h($p['color_class']); ?>" <?php if (($task['priority'] ?? '') == $p['id']) echo 'selected'; ?>><?php echo h($p['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="taskPriority">Priority</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="projectSelect" name="project_id">
            <option value="">Select project</option>
            <?php foreach ($projects as $p): ?>
              <option value="<?php echo $p['id']; ?>" <?php if (($task['project_id'] ?? '') == $p['id']) echo 'selected'; ?>><?php echo h($p['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="projectSelect">Project</label>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-floating">
          <select class="form-select" id="agencySelect" name="agency_id">
            <option value="">Select agency</option>
            <?php foreach ($agencies as $a): ?>
              <option value="<?php echo $a['id']; ?>" <?php if (($task['agency_id'] ?? '') == $a['id']) echo 'selected'; ?>><?php echo h($a['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="agencySelect">Agency</label>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-floating">
          <select class="form-select" id="divisionSelect" name="division_id">
            <option value="">Select division</option>
            <?php foreach ($divisions as $d): ?>
              <option value="<?php echo $d['id']; ?>" <?php if (($task['division_id'] ?? '') == $d['id']) echo 'selected'; ?>><?php echo h($d['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="divisionSelect">Division</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating form-floating-advance-select">
          <label for="assignedUsers">Assigned Users</label>
          <select class="form-select" id="assignedUsers" name="assigned_users[]" multiple data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}'>
            <?php foreach ($users as $u): ?>
              <option value="<?php echo $u['id']; ?>" <?php if (in_array($u['id'], $assignedUsers)) echo 'selected'; ?>><?php echo h($u['email']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="row g-3 justify-content-end">
          <div class="col-auto">
            <a class="btn btn-phoenix-primary" href="index.php">Cancel</a>
          </div>
          <div class="col-auto">
            <button class="btn btn-atlis" type="submit">Save Task</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

