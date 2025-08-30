<?php
// List view of agencies
?>
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive scrollbar">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody class="list">
          <?php foreach ($agencies as $agency): ?>
            <tr>
              <td class="align-middle name">
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
              </td>
              <td class="align-middle status">
                <?= render_status_badge($statusList, $agency['status']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
