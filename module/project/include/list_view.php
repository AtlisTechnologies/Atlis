<?php
// List view of projects
?>
<?php if (user_has_permission('project','create')): ?>
<div class="mb-3">
  <a href="index.php?action=create" class="btn btn-success">Create Project</a>
</div>
<?php endif; ?>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($projects as $proj): ?>
        <tr>
          <td><?php echo h($proj['name'] ?? ''); ?></td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($proj['status_color'] ?? 'secondary'); ?>">
              <span class="badge-label"><?php echo h($proj['status_label'] ?? ''); ?></span>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
