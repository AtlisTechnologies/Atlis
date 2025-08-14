<?php
// Form for creating a project
require_once __DIR__ . '/../../../includes/functions.php';
?>
<div class="container-fluid">
  <h2 class="mb-4">Create a project</h2>
  <div class="row">
    <div class="col-xl-9">
      <form class="row g-3 mb-6" method="post" action="index.php?action=create">
        <div class="col-sm-6 col-md-8">
          <div class="form-floating">
            <input class="form-control" id="projectName" type="text" name="name" placeholder="Project title" />
            <label for="projectName">Project title</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="projectStatus" name="status">
              <?php foreach ($statusMap as $s): ?>
                <option value="<?= h($s['id']); ?>"><?= h($s['label']); ?></option>
              <?php endforeach; ?>
            </select>
            <label for="projectStatus">Status</label>
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
                <option value="<?= h($agency['id']); ?>"><?= h($agency['name']); ?></option>
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
                <option value="<?= h($division['id']); ?>"><?= h($division['name']); ?></option>
              <?php endforeach; ?>
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
              <a class="btn btn-phoenix-primary px-5" href="index.php">Cancel</a>
            </div>
            <div class="col-auto">
              <button class="btn btn-primary px-5 px-sm-15" type="submit">Create Project</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

