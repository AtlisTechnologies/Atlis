<?php
// List view of agencies
?>
<div class="card mb-3">
  <div class="card-body">
    <form method="get" class="row g-2">
      <input type="hidden" name="action" value="list">
      <div class="col-sm-3">
        <input class="form-control" type="text" name="name" placeholder="Search name" value="<?= h($filters['name']); ?>">
      </div>
      <div class="col-sm-2">
        <select class="form-select" name="status">
          <option value="">All Statuses</option>
          <?php foreach ($statusList as $id => $status): ?>
            <option value="<?= $id ?>" <?= $filters['status']==$id ? 'selected' : '' ?>><?= h($status['label']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-3">
        <select class="form-select" name="org">
          <option value="">All Organizations</option>
          <?php foreach ($organizations as $org): ?>
            <option value="<?= $org['id']; ?>" <?= $filters['org']==$org['id'] ? 'selected' : '' ?>><?= h($org['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-2">
        <select class="form-select" name="lead">
          <option value="">All Leads</option>
          <?php foreach ($leadUsers as $user): ?>
            <option value="<?= $user['id']; ?>" <?= $filters['lead']==$user['id'] ? 'selected' : '' ?>><?= h($user['name']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-sm-2">
        <button class="btn btn-primary w-100" type="submit">Filter</button>
      </div>
    </form>
  </div>
</div>

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
                  <a href="download.php?id=<?= $agency['id']; ?>" class="me-1">
                    <?php if (strpos($agency['file_type'], 'image/') === 0): ?>
                      <img src="uploads/agency/<?= e($agency['file_path']); ?>" alt="<?= e($agency['file_name']); ?>" class="rounded" style="height:24px; width:24px; object-fit:cover;">
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
