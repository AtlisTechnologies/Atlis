<?php
// Board view of agencies grouped by status
$columns = [];
foreach ($agencies as $agency) {
  $status = $agency['status_label'] ?? 'Unassigned';
  $columns[$status][] = $agency;
}
?>
<div class="row g-3">
  <?php foreach ($columns as $status => $items): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card">
        <div class="card-header bg-body-tertiary">
          <h6 class="mb-0"><?php echo htmlspecialchars($status); ?></h6>
        </div>
        <div class="card-body">
          <?php foreach ($items as $agency): ?>
            <div class="card mb-2">
              <div class="card-body p-2">
                <?php echo htmlspecialchars($agency['name']); ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
