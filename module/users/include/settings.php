<?php
// User settings page
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Users</a></li>
    <li class="breadcrumb-item active" aria-current="page">Settings</li>
  </ol>
</nav>
<h2 class="mb-4">User Settings</h2>
<?php if (!empty($_GET['saved'])): ?>
<div class="alert alert-success" role="alert">Settings saved.</div>
<?php endif; ?>
<div class="row">
  <div class="col-xl-8">
    <form class="row g-3 mb-6" method="post" action="index.php?action=save-settings">
      <h5 class="mb-3">Defaults</h5>
      <div class="col-12">
        <h6 class="mb-2">Projects</h6>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="defaultProjectStatus" name="project_status">
            <option value="">No default</option>
            <?php foreach ($projectStatusItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php if (($userDefaults['PROJECT_STATUS'] ?? '') == $item['id']) echo 'selected'; ?>><?php echo h($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="defaultProjectStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="defaultProjectPriority" name="project_priority">
            <option value="">No default</option>
            <?php foreach ($projectPriorityItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php if (($userDefaults['PROJECT_PRIORITY'] ?? '') == $item['id']) echo 'selected'; ?>><?php echo h($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="defaultProjectPriority">Priority</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="defaultProjectType" name="project_type">
            <option value="">No default</option>
            <?php foreach ($projectTypeItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php if (($userDefaults['PROJECT_TYPE'] ?? '') == $item['id']) echo 'selected'; ?>><?php echo h($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="defaultProjectType">Type</label>
        </div>
      </div>
      <div class="col-12 mt-3">
        <h6 class="mb-2">Tasks</h6>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="defaultTaskStatus" name="task_status">
            <option value="">No default</option>
            <?php foreach ($taskStatusItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php if (($userDefaults['TASK_STATUS'] ?? '') == $item['id']) echo 'selected'; ?>><?php echo h($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="defaultTaskStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="defaultTaskPriority" name="task_priority">
            <option value="">No default</option>
            <?php foreach ($taskPriorityItems as $item): ?>
              <option value="<?php echo $item['id']; ?>" <?php if (($userDefaults['TASK_PRIORITY'] ?? '') == $item['id']) echo 'selected'; ?>><?php echo h($item['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="defaultTaskPriority">Priority</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="row g-3 justify-content-end mt-3">
          <div class="col-auto">
            <button class="btn btn-success px-5" type="submit">Save Settings</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
