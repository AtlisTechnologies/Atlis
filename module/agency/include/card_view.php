<?php
// Card view of agencies
?>
<div class="container-fluid">
  <div class="row g-3">
    <?php foreach ($agencies as $agency): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($agency['name']); ?></h5>
            <p class="mb-0">
              <?= render_status_badge($statusList, $agency['status']) ?>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
