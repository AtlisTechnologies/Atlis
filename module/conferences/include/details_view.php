<?php
?>
<div class="container py-4">
  <div class="card">
    <div class="card-body">
      <h2 class="mb-3"><?= h($conference['name'] ?? '') ?></h2>
      <p><span class="fas fa-calendar me-2"></span><?= h($conference['start_datetime'] ?? '') ?><?= !empty($conference['end_datetime']) ? ' - ' . h($conference['end_datetime']) : '' ?></p>
      <p><span class="fas fa-location-dot me-2"></span><?= h($conference['venue'] ?? '') ?></p>
      <div><?= nl2br(h($conference['description'] ?? '')) ?></div>
    </div>
  </div>
</div>
