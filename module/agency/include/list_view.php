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
                <?php if (!empty($agency['file_name']) && strpos($agency['file_type'], 'image/') === 0): ?>
                  <a href="uploads/agency/<?= e($agency['file_path']); ?>" data-fslightbox="agency" class="me-1">
                    <img src="uploads/agency/<?= e($agency['file_path']); ?>" alt="<?= e($agency['file_name']); ?>" class="rounded" style="height:24px; width:24px; object-fit:cover;">
                  </a>
                <?php endif; ?>
                <?= e($agency['name']); ?>
                <?php if (!empty($agency['file_name'])): ?>
                  <a href="download.php?type=agency&id=<?= $agency['id']; ?>" class="ms-1 text-body">
                    <i class="fa-regular fa-paperclip"></i>
                  </a>
                <?php endif; ?>
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
