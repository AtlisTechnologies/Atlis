<?php
// Board view of agencies grouped by status
$columns = [];
foreach ($agencies as $agency) {
  $status = $agency['status_label'] ?? 'Unassigned';
  $color  = $agency['status_color'] ?? 'secondary';
  $columns[$status]['color'] = $color;
  $columns[$status]['items'][] = $agency;
}
?>
<div class="row g-3">
  <?php foreach ($columns as $status => $data): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card">
        <div class="card-header bg-body-tertiary">
          <h6 class="mb-0"><span class="badge badge-phoenix badge-phoenix-<?= htmlspecialchars($data['color']); ?>"><?php echo htmlspecialchars($status); ?></span></h6>
        </div>
        <div class="card-body">
          <?php foreach (($data['items'] ?? []) as $agency): ?>
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
