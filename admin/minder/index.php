<?php
require '../admin_header.php';
require_permission('minder_module','read');
?>
<h2 class="mb-4">Minder</h2>
<div class="row g-3">
  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Reminders</h5>
        <p class="card-text">Manage reminders.</p>
        <a href="reminders/" class="btn btn-primary mt-auto">Open</a>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Notes</h5>
        <p class="card-text">Manage notes.</p>
        <a href="notes/" class="btn btn-primary mt-auto">Open</a>
      </div>
    </div>
  </div>
  <div class="col-md-6 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Tasks</h5>
        <p class="card-text">Manage tasks.</p>
        <a href="tasks/index.php" class="btn btn-primary mt-auto">Open</a>
      </div>
    </div>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
