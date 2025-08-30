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
<div class="mb-9">
  <div class="row g-6">
    <div class="col-12 col-xl-4">
      <div class="card mb-5">
        <div class="card-body">
          <div class="border-bottom border-translucent border-dashed pb-3 mb-4">
            <h5 class="text-body mb-3">Profile Visibility</h5>
            <div class="form-check">
              <input class="form-check-input" id="visibilityPublic" type="radio" name="profileVisibility" checked>
              <label class="form-check-label fs-8" for="visibilityPublic">Public</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" id="visibilityPrivate" type="radio" name="profileVisibility">
              <label class="form-check-label fs-8" for="visibilityPrivate">Private</label>
            </div>
          </div>
          <div class="mb-4">
            <div class="form-check form-switch">
              <input class="form-check-input" id="toggleEmail" type="checkbox" checked>
              <label class="form-check-label fs-8" for="toggleEmail">Show your email</label>
            </div>
            <div class="form-check form-switch">
              <input class="form-check-input" id="toggleFollow" type="checkbox">
              <label class="form-check-label fs-8" for="toggleFollow">Allow users to follow you</label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-8">
      <form class="row g-3" method="post" action="index.php?action=save-settings">
        <div class="mb-6 col-12">
          <h4 class="mb-4">Personal Information</h4>
          <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="userTimezone" name="timezone_id">
                    <option value="">Select timezone</option>
                    <?php foreach ($timezoneItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userTimezoneId ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="userTimezone">Timezone</label>
                </div><span class="fa-regular fa-clock text-body fs-9 form-icon"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-6 col-12">
          <h4 class="mb-4">Defaults</h4>
          <div class="row g-3">
            <div class="col-12">
              <h6 class="mb-2">Projects</h6>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultProjectStatus" name="project_status">
                    <option value="">No default</option>
                    <?php foreach ($projectStatusItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['PROJECT_STATUS'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultProjectStatus">Status</label>
                </div><span class="fa-solid fa-list text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultProjectPriority" name="project_priority">
                    <option value="">No default</option>
                    <?php foreach ($projectPriorityItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['PROJECT_PRIORITY'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultProjectPriority">Priority</label>
                </div><span class="fa-solid fa-bookmark text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultProjectType" name="project_type">
                    <option value="">No default</option>
                    <?php foreach ($projectTypeItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['PROJECT_TYPE'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultProjectType">Type</label>
                </div><span class="fa-solid fa-layer-group text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="col-12 mt-3">
              <h6 class="mb-2">Tasks</h6>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultTaskStatus" name="task_status">
                    <option value="">No default</option>
                    <?php foreach ($taskStatusItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['TASK_STATUS'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultTaskStatus">Status</label>
                </div><span class="fa-solid fa-list-check text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultTaskPriority" name="task_priority">
                    <option value="">No default</option>
                    <?php foreach ($taskPriorityItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['TASK_PRIORITY'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultTaskPriority">Priority</label>
                </div><span class="fa-solid fa-circle-exclamation text-body fs-9 form-icon"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-6 col-12">
          <h4 class="mb-4">Calendar</h4>
          <div class="row g-3">
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultCalendar" name="calendar_default">
                    <option value="">No default</option>
                    <?php foreach ($userCalendars as $cal): ?>
                      <option value="<?= $cal['id']; ?>" <?= ($userDefaults['CALENDAR_DEFAULT'] ?? '') == $cal['id'] ? 'selected' : ''; ?>><?= h($cal['name']); if($cal['is_private'] == 1){ echo " - Private"; } ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultCalendar">Default Calendar</label>
                </div><span class="fa-regular fa-calendar text-body fs-9 form-icon"></span>
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
              <div class="form-icon-container">
                <div class="form-floating">
                  <select class="form-select form-icon-input" id="defaultEventType" name="calendar_event_type_default">
                    <option value="">No default</option>
                    <?php foreach ($calendarEventTypeItems as $item): ?>
                      <option value="<?= $item['id']; ?>" <?= ($userDefaults['CALENDAR_EVENT_TYPE_DEFAULT'] ?? '') == $item['id'] ? 'selected' : ''; ?>><?= h($item['label']); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label class="text-body-tertiary form-icon-label fs-8" for="defaultEventType">Default Event Type</label>
                </div><span class="fa-solid fa-tag text-body fs-9 form-icon"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="row g-3 justify-content-end">
            <div class="col-auto">
              <button class="btn btn-primary px-5" type="submit">Save Settings</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

