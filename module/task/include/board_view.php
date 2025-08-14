<?php
// Board view of tasks grouped by status
?>
<div class="row g-3">
  <?php foreach ($statusMap as $id => $status): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <h5 class="mb-3"><?php echo htmlspecialchars($status['label'] ?? ''); ?></h5>
      <?php foreach ($tasks as $task): if (($task['status'] ?? '') == $id): ?>
        <div class="card mb-2">
          <div class="card-body p-2">
            <?php echo htmlspecialchars($task['name'] ?? ''); ?>
          </div>
        </div>
      <?php endif; endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

