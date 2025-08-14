<?php
// Form for creating a project
?>
<div class="container-fluid">
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
        <div class="col-12 gy-6">
          <div class="form-floating">
            <textarea class="form-control" id="projectDescription" name="description" placeholder="Description" style="height:100px"></textarea>
            <label for="projectDescription">Project description</label>
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
