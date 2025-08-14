<?php
// Form for creating a project
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
                <option value="<?php echo htmlspecialchars($s['id']); ?>"><?php echo htmlspecialchars($s['label']); ?></option>
              <?php endforeach; ?>
            </select>
            <label for="projectStatus">Status</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="defaultTaskView" name="task_view">
              <option selected="selected">Select task view</option>
              <option value="technical">technical</option>
              <option value="external">external</option>
              <option value="organizational">organizational</option>
            </select>
            <label for="defaultTaskView">Default task view</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="projectPrivacy" name="privacy">
              <option selected="selected">Select privacy</option>
              <option value="1">Data Privacy One</option>
              <option value="2">Data Privacy Two</option>
              <option value="3">Data Privacy Three</option>
            </select>
            <label for="projectPrivacy">Project privacy</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="projectTeam" name="team">
              <option selected="selected">Select team</option>
              <option value="1">Team One</option>
              <option value="2">Team Two</option>
              <option value="3">Team Three</option>
            </select>
            <label for="projectTeam">Team</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="projectAssignees" name="assignees">
              <option selected="selected">Select assignees</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
            <label for="projectAssignees">People</label>
          </div>
        </div>
        <div class="col-sm-6 col-md-4">
          <div class="form-floating">
            <select class="form-select" id="projectLead" name="admin">
              <option selected="selected">Select admin</option>
              <option value="1">Data Privacy One</option>
              <option value="2">Data Privacy Two</option>
              <option value="3">Data Privacy Three</option>
            </select>
            <label for="projectLead">Project Lead</label>
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
          <div class="flatpickr-input-container">
            <div class="form-floating">
              <input class="form-control datetimepicker" id="deadline" type="text" name="deadline" placeholder="deadline" data-options='{"disableMobile":true}' />
              <label class="ps-6" for="deadline">Deadline</label><span class="uil uil-calendar-alt flatpickr-icon text-body-tertiary"></span>
            </div>
          </div>
        </div>
        <div class="col-12 gy-6">
          <div class="form-floating">
            <textarea class="form-control" id="projectDescription" name="description" placeholder="Leave a comment here" style="height:100px"></textarea>
            <label for="projectDescription">project overview</label>
          </div>
        </div>
        <div class="col-md-6 gy-6">
          <div class="form-floating">
            <select class="form-select" id="projectClient" name="client">
              <option selected="selected">Select client</option>
              <option value="1">Client One</option>
              <option value="2">Client Two</option>
              <option value="3">Client Three</option>
            </select>
            <label for="projectClient">client</label>
          </div>
        </div>
        <div class="col-md-6 gy-md-6">
          <div class="form-floating">
            <input class="form-control" id="projectBudget" type="text" name="budget" placeholder="Budget" />
            <label for="projectBudget">Budget</label>
          </div>
        </div>
        <div class="col-12 gy-6">
          <div class="form-floating form-floating-advance-select">
            <label for="projectTags">Add tags</label>
            <select class="form-select" id="projectTags" name="tags[]" data-choices="data-choices" multiple="multiple" data-options='{"removeItemButton":true,"placeholder":true}'>
              <option value="Stupidity" selected="selected">Stupidity</option>
              <option value="Jerry">Jerry</option>
              <option value="Not_the_mouse">Not_the_mouse</option>
              <option value="Rick">Rick</option>
              <option value="Biology">Biology</option>
              <option value="Neurology">Neurology</option>
              <option value="Brainlessness">Brainlessness</option>
            </select>
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

