<?php
// Card view of tasks
?>
<div class="container-fluid">
  <div class="row g-3">
    <?php foreach ($tasks as $task): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo h($task['name'] ?? ''); ?></h5>
            <p class="mb-0">
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['status_color'] ?? ''); ?>">
                <span class="badge-label"><?php echo h($task['status_label'] ?? ''); ?></span>
              </span>
              <span class="badge badge-phoenix fs-10 badge-phoenix-secondary ms-1">
                <span class="badge-label"><?php echo h($task['priority_label'] ?? ''); ?></span>
              </span>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

