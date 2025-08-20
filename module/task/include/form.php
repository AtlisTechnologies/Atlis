<?php
// Form for creating or editing tasks using Phoenix layout
?>
<?php $isEdit = !empty($task['id']); ?>
<?php if (!empty($isModal)): ?>
<form id="taskForm" class="row g-3" method="post" action="index.php?action=save">
  <input type="hidden" name="id" value="<?php echo h($task['id'] ?? ''); ?>">
  <div class="modal-header">
    <h5 class="modal-title"><?php echo $isEdit ? 'Edit Task' : 'Create Task'; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
    <div class="row g-3">
      <div class="col-12">
        <div class="form-floating">
          <input class="form-control" id="taskName" type="text" name="name" placeholder="Task name" value="<?php echo h($task['name'] ?? ''); ?>" required>
          <label for="taskName">Task name</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskDescription" name="description" placeholder="Description" style="height:100px"><?php echo h($task['description'] ?? ''); ?></textarea>
          <label for="taskDescription">Description</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskRequirements" name="requirements" placeholder="Requirements" style="height:100px"><?php echo h($task['requirements'] ?? ''); ?></textarea>
          <label for="taskRequirements">Requirements</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskSpecifications" name="specifications" placeholder="Specifications" style="height:100px"><?php echo h($task['specifications'] ?? ''); ?></textarea>
          <label for="taskSpecifications">Specifications</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskStatus" name="status" required>
            <?php foreach ($statusMap as $s): ?>
              <?php $sel = (($task['status'] ?? null) == $s['id']) || (empty($task['status']) && !empty($s['is_default'])); ?>
              <option value="<?php echo $s['id']; ?>" data-color="<?php echo h($s['color_class']); ?>" <?php echo $sel ? 'selected' : ''; ?>><?php echo h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="taskStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskPriority" name="priority" required>
            <?php foreach ($priorityMap as $p): ?>
              <?php $sel = (($task['priority'] ?? null) == $p['id']) || (empty($task['priority']) && !empty($p['is_default'])); ?>
              <option value="<?php echo $p['id']; ?>" data-color="<?php echo h($p['color_class']); ?>" <?php echo $sel ? 'selected' : ''; ?>><?php echo h($p['label']); ?></option>
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
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="startDate" type="text" name="start_date" placeholder="Start date" value="<?php echo h($task['start_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="startDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="dueDate" type="text" name="due_date" placeholder="Due date" value="<?php echo h($task['due_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="dueDate">Due date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="completeDate" type="text" name="complete_date" placeholder="Complete date" value="<?php echo h($task['complete_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="completeDate">Complete date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-check form-switch mt-4">
          <input class="form-check-input" id="completedCheck" type="checkbox" name="completed" value="1" <?php if (!empty($task['completed'])) echo 'checked'; ?>>
          <label class="form-check-label" for="completedCheck">Completed</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <input class="form-control" id="progressPercent" type="number" name="progress_percent" min="0" max="100" placeholder="Progress %" value="<?php echo h($task['progress_percent'] ?? ''); ?>">
          <label for="progressPercent">Progress %</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskMemo" name="memo" placeholder="Memo" style="height:100px"><?php echo h($task['memo'] ?? ''); ?></textarea>
          <label for="taskMemo">Memo</label>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button class="btn btn-atlis" type="submit">Save Task</button>
  </div>
</form>
<?php else: ?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Tasks</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $isEdit ? 'Edit' : 'Create'; ?></li>
  </ol>
</nav>
<h2 class="mb-4"><?php echo $isEdit ? 'Edit Task' : 'Create Task'; ?></h2>
<div class="row">
  <div class="col-xl-9">
    <form id="taskForm" class="row g-3 mb-6" method="post" action="index.php?action=save">
      <input type="hidden" name="id" value="<?php echo h($task['id'] ?? ''); ?>">
      <div class="col-12">
        <div class="form-floating">
          <input class="form-control" id="taskName" type="text" name="name" placeholder="Task name" value="<?php echo h($task['name'] ?? ''); ?>" required>
          <label for="taskName">Task name</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskDescription" name="description" placeholder="Description" style="height:100px"><?php echo h($task['description'] ?? ''); ?></textarea>
          <label for="taskDescription">Description</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskRequirements" name="requirements" placeholder="Requirements" style="height:100px"><?php echo h($task['requirements'] ?? ''); ?></textarea>
          <label for="taskRequirements">Requirements</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskSpecifications" name="specifications" placeholder="Specifications" style="height:100px"><?php echo h($task['specifications'] ?? ''); ?></textarea>
          <label for="taskSpecifications">Specifications</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskStatus" name="status" required>
            <?php foreach ($statusMap as $s): ?>
              <?php $sel = (($task['status'] ?? null) == $s['id']) || (empty($task['status']) && !empty($s['is_default'])); ?>
              <option value="<?php echo $s['id']; ?>" data-color="<?php echo h($s['color_class']); ?>" <?php echo $sel ? 'selected' : ''; ?>><?php echo h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="taskStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="taskPriority" name="priority" required>
            <?php foreach ($priorityMap as $p): ?>
              <?php $sel = (($task['priority'] ?? null) == $p['id']) || (empty($task['priority']) && !empty($p['is_default'])); ?>
              <option value="<?php echo $p['id']; ?>" data-color="<?php echo h($p['color_class']); ?>" <?php echo $sel ? 'selected' : ''; ?>><?php echo h($p['label']); ?></option>
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
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="startDate" type="text" name="start_date" placeholder="Start date" value="<?php echo h($task['start_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="startDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="dueDate" type="text" name="due_date" placeholder="Due date" value="<?php echo h($task['due_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="dueDate">Due date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="completeDate" type="text" name="complete_date" placeholder="Complete date" value="<?php echo h($task['complete_date'] ?? ''); ?>" data-options='{"disableMobile":true}'>
            <label class="ps-6" for="completeDate">Complete date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-check form-switch mt-4">
          <input class="form-check-input" id="completedCheck" type="checkbox" name="completed" value="1" <?php if (!empty($task['completed'])) echo 'checked'; ?>>
          <label class="form-check-label" for="completedCheck">Completed</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <input class="form-control" id="progressPercent" type="number" name="progress_percent" min="0" max="100" placeholder="Progress %" value="<?php echo h($task['progress_percent'] ?? ''); ?>">
          <label for="progressPercent">Progress %</label>
        </div>
      </div>
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="taskMemo" name="memo" placeholder="Memo" style="height:100px"><?php echo h($task['memo'] ?? ''); ?></textarea>
          <label for="taskMemo">Memo</label>
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
<?php endif; ?>

