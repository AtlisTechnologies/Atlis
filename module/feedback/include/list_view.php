<?php
// List view for feedback records
?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Feedback List</h5>
    <?php if (user_has_permission('feedback', 'create')): ?>
      <a href="?action=create" class="btn btn-primary btn-sm">Add Feedback</a>
    <?php endif; ?>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-sm table-hover mb-0">
        <thead class="bg-body-tertiary">
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Date</th>
            <?php if (user_has_permission('feedback', 'update') || user_has_permission('feedback', 'delete')): ?>
              <th class="text-end">Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($feedback as $row): ?>
            <tr>
              <td><a href="?action=details&id=<?= (int)$row['id']; ?>"><?= h($row['title']); ?></a></td>
              <td><?= h($typeMap[$row['type']]['label'] ?? ''); ?></td>
              <td><?= h($row['date_created']); ?></td>
              <?php if (user_has_permission('feedback', 'update') || user_has_permission('feedback', 'delete')): ?>
                <td class="text-end">
                  <?php if (user_has_permission('feedback', 'update')): ?>
                    <a href="?action=edit&id=<?= (int)$row['id']; ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                  <?php endif; ?>
                  <?php if (user_has_permission('feedback', 'delete')): ?>
                    <form action="functions/delete.php" method="post" class="d-inline" onsubmit="return confirm('Delete this feedback?');">
                      <input type="hidden" name="id" value="<?= (int)$row['id']; ?>">
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
