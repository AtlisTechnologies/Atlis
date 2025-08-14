<?php
// Card view of projects
?>
<div class="container-fluid">
  <?php if (user_has_permission('project','create')): ?>
  <div class="mb-3">
    <a href="index.php?action=create" class="btn btn-primary">Create Project</a>
  </div>
  <?php endif; ?>
  <div class="row g-3">
    <?php foreach ($projects as $project): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($project['name'] ?? ''); ?></h5>
            <p class="mb-0">
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($project['status_color'] ?? ''); ?>">
                  <span class="badge-label"><?php echo htmlspecialchars($project['status_label'] ?? ''); ?></span>
              </span>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
