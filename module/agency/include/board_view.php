<?php
// Board view of agencies grouped by status
$columns = [];
foreach ($agencies as $agency) {
  $sid = $agency['status'] ?? 0;
  $columns[$sid]['items'][] = $agency;
}
?>
<div class="row g-3">
  <?php foreach ($columns as $sid => $data): ?>
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card">
        <div class="card-header bg-body-tertiary">
          <h6 class="mb-0"><?= render_status_badge($statusList, $sid) ?></h6>
        </div>
        <div class="card-body">
          <?php foreach (($data['items'] ?? []) as $agency): ?>
            <div class="card mb-2">
              <div class="card-body p-2">
                <?php if (!empty($agency['file_name'])): ?>
                  <?php
                    $fileUrl = 'uploads/agency/' . $agency['file_path'];
                    $mime = $agency['file_type'] ?? '';
                    $previewable = preg_match('/^(image|video|audio|text)\//', $mime) || $mime === 'application/pdf';
                    $isImage = strpos($mime, 'image/') === 0;
                  ?>
                  <?php if ($previewable): ?>
                    <a href="<?= h($fileUrl); ?>" data-fslightbox="agency"<?= $isImage ? '' : ' data-type="iframe"' ?> class="me-1">
                      <?php if ($isImage): ?>
                        <img src="<?= h($fileUrl); ?>" alt="<?= e($agency['file_name']); ?>" class="rounded" style="height:24px; width:24px; object-fit:cover;">
                      <?php else: ?>
                        <i class="fa-regular fa-file"></i>
                      <?php endif; ?>
                    </a>
                  <?php else: ?>
                    <a href="<?= h($fileUrl); ?>" target="_blank" rel="noopener" class="me-1"><i class="fa-regular fa-file"></i></a>
                  <?php endif; ?>
                  <a href="download.php?type=agency&id=<?= $agency['id']; ?>" class="ms-1 text-body" title="Download">
                    <i class="fa-solid fa-download"></i>
                  </a>
                <?php endif; ?>
                <?= e($agency['name']); ?>
                <?php if (!empty($agency['organization_name'])): ?>
                  <span class="badge bg-info-subtle text-info ms-1"><?= h($agency['organization_name']); ?></span>
                <?php endif; ?>
                <span class="badge bg-primary-subtle text-primary ms-1"><?= (int)$agency['user_count']; ?></span>
                <span class="badge bg-secondary-subtle text-secondary ms-1"><?= (int)$agency['person_count']; ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
