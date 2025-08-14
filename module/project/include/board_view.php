<?php
// Board view of projects grouped by status
?>
<div class="row g-3">
  <?php foreach ($statusMap as $id => $status): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <h5 class="mb-3"><?php echo h($status['label'] ?? ''); ?></h5>
      <?php foreach ($projects as $proj): if (($proj['status'] ?? '') == $id): ?>
        <div class="card mb-2">
          <div class="card-body p-2">
            <?php echo h($proj['name'] ?? ''); ?>
          </div>
        </div>
      <?php endif; endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

