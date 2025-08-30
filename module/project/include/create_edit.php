<?php
require_once __DIR__ . '/../../../includes/functions.php';
require_permission('project','create');

// Ensure lookup lists are available
$statusMap   = $statusMap   ?? get_lookup_items($pdo, 'PROJECT_STATUS');
$priorityMap = $priorityMap ?? get_lookup_items($pdo, 'PROJECT_PRIORITY');
$typeMap     = $typeMap     ?? get_lookup_items($pdo, 'PROJECT_TYPE');

$defaultStatusId   = get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_STATUS');
$defaultPriorityId = get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_PRIORITY');
$defaultTypeId     = get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_TYPE');
$defaultAgencyId   = $defaultAgencyId   ?? get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_AGENCY');
$defaultDivisionId = $defaultDivisionId ?? get_user_default_lookup_item($pdo, $this_user_id, 'PROJECT_DIVISION');
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
  </ol>
</nav>
<h2 class="mb-4">Create a project</h2>
<div class="row">
  <div class="col-xl-9">
    <form class="row g-3 mb-6" method="post" action="functions/create.php">
      <?= csrf_field(); ?>
      <div class="col-sm-6 col-md-8">
        <div class="form-floating">
          <input class="form-control" id="projectName" type="text" name="name" placeholder="Project title" required />
          <label for="projectName">Project title</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <?php
            if ($defaultStatusId === null) {
              foreach ($statusMap as $s) {
                if (!empty($s['is_default'])) {
                  $defaultStatusId = $s['id'];
                  break;
                }
              }
            }
          ?>
          <select class="form-select" id="projectStatus" name="status" required>
            <option value="" <?= $defaultStatusId ? '' : 'selected'; ?>>Select status</option>
            <?php foreach ($statusMap as $s): ?>
              <option value="<?= h($s['id']); ?>" <?= ($defaultStatusId == $s['id']) ? 'selected' : ''; ?>><?= h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="projectStatus">Status</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <?php
            if ($defaultPriorityId === null) {
              foreach ($priorityMap as $p) {
                if (!empty($p['is_default'])) {
                  $defaultPriorityId = $p['id'];
                  break;
                }
              }
            }
          ?>
          <select class="form-select" id="projectPriority" name="priority" required>
            <option value="" <?= $defaultPriorityId ? '' : 'selected'; ?>>Select priority</option>
            <?php foreach ($priorityMap as $p): ?>
              <option value="<?= h($p['id']); ?>" <?= ($defaultPriorityId == $p['id']) ? 'selected' : ''; ?>><?= h($p['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="projectPriority">Priority</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <?php
            if ($defaultTypeId === null) {
              foreach ($typeMap as $t) {
                if (!empty($t['is_default'])) {
                  $defaultTypeId = $t['id'];
                  break;
                }
              }
            }
          ?>
          <select class="form-select" id="projectType" name="type" required>
            <option value="" <?= $defaultTypeId ? '' : 'selected'; ?>>Select type</option>
            <?php foreach ($typeMap as $t): ?>
              <option value="<?= h($t['id']); ?>" <?= ($defaultTypeId == $t['id']) ? 'selected' : ''; ?>><?= h($t['label']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="projectType">Type</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="flatpickr-input-container">
          <div class="form-floating">
            <input class="form-control datetimepicker" id="startDate" type="text" name="start_date" placeholder="start date" data-options='{"disableMobile":true}' />
            <label class="ps-6" for="startDate">Start date</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="agencySelect" name="agency_id">
            <option value="">Select agency</option>
            <?php foreach ($agencies as $agency): ?>
              <option value="<?= h($agency['id']); ?>" <?= ($defaultAgencyId ?? '') == $agency['id'] ? 'selected' : ''; ?>><?= h($agency['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <label for="agencySelect">Agency</label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating">
          <select class="form-select" id="divisionSelect" name="division_id" disabled>
            <option value="">Select division</option>
          </select>
          <label for="divisionSelect">Division</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectDescription" name="description" placeholder="Leave a description here" style="height:100px"></textarea>
          <label for="projectDescription">Project description</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectRequirements" name="requirements" placeholder="Requirements" style="height:100px"></textarea>
          <label for="projectRequirements">Requirements</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="form-floating">
          <textarea class="form-control" id="projectSpecifications" name="specifications" placeholder="Specifications" style="height:100px"></textarea>
          <label for="projectSpecifications">Specifications</label>
        </div>
      </div>
      <div class="col-12 gy-6">
        <div class="row g-3 justify-content-end">
          <div class="col-auto">
            <a class="btn btn-warning px-5" href="index.php">Cancel</a>
          </div>
          <div class="col-auto">
            <button class="btn btn-success px-5 px-sm-15" type="submit">Create Project</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const divisions = <?= json_encode($divisions); ?>;
  const agencySelect = document.getElementById('agencySelect');
  const divisionSelect = document.getElementById('divisionSelect');
  const defaultAgencyId = <?= json_encode($defaultAgencyId ?? null); ?>;
  const defaultDivisionId = <?= json_encode($defaultDivisionId ?? null); ?>;

  function populateDivisions() {
    const agencyId = agencySelect.value;
    divisionSelect.innerHTML = '<option value="">Select division</option>';
    if (!agencyId) {
      divisionSelect.disabled = true;
      divisionSelect.value = '';
      return;
    }
    divisionSelect.disabled = false;
    divisions.filter(d => d.agency_id == agencyId).forEach(d => {
      const opt = document.createElement('option');
      opt.value = d.id;
      opt.textContent = d.name;
      divisionSelect.appendChild(opt);
    });
    if (defaultDivisionId) {
      const div = divisions.find(d => d.id == defaultDivisionId);
      if (div && div.agency_id == agencyId) {
        divisionSelect.value = defaultDivisionId;
      }
    }
  }

  if (defaultDivisionId && !defaultAgencyId) {
    const div = divisions.find(d => d.id == defaultDivisionId);
    if (div) { agencySelect.value = String(div.agency_id); }
  } else if (defaultAgencyId) {
    agencySelect.value = String(defaultAgencyId);
  }

  populateDivisions();

  agencySelect.addEventListener('change', populateDivisions);

  divisionSelect.addEventListener('change', function () {
    const div = divisions.find(d => d.id == divisionSelect.value);
    if (div && agencySelect.value && div.agency_id != agencySelect.value) {
      alert('Division does not belong to selected agency');
      divisionSelect.value = '';
    }
  });

  document.querySelector('form').addEventListener('submit', function (e) {
    const agencyId = agencySelect.value;
    const divisionId = divisionSelect.value;
    if (!agencyId && !divisionId) {
      alert('Please select an agency or division');
      e.preventDefault();
      return;
    }
    if (!agencyId && divisionId) {
      const div = divisions.find(d => d.id == divisionId);
      if (div) {
        agencySelect.value = div.agency_id;
      }
    }
  });
});
</script>
