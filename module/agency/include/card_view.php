<?php
// Card view of agencies
?>
<div class="container-fluid">
  <div class="row g-3">
    <?php foreach ($agencies as $agency): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h5 class="card-title mb-1">
              <?php if (!empty($agency['file_name'])): ?>
                <a href="download.php?id=<?= $agency['id']; ?>" class="me-1">
                  <?php if (strpos($agency['file_type'], 'image/') === 0): ?>
                    <img src="uploads/agency/<?= e($agency['file_path']); ?>" alt="<?= e($agency['file_name']); ?>" class="rounded" style="height:32px; width:32px; object-fit:cover;">
                  <?php else: ?>
                    <i class="fa-regular fa-paperclip"></i>
                  <?php endif; ?>
                </a>
              <?php endif; ?>
              <?php echo e($agency['name']); ?>
              <?php if (!empty($agency['organization_name'])): ?>
                <span class="badge bg-info-subtle text-info ms-1"><?= h($agency['organization_name']); ?></span>
              <?php endif; ?>
              <span class="badge bg-primary-subtle text-primary ms-1"><?= (int)$agency['user_count']; ?></span>
              <span class="badge bg-secondary-subtle text-secondary ms-1"><?= (int)$agency['person_count']; ?></span>
            </h5>
            <p class="mb-0">
              <?= render_status_badge($statusList, $agency['status']) ?>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
