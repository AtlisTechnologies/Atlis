<?php
// List view of projects
?>
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
          <td><?php echo htmlspecialchars($proj['name'] ?? ''); ?></td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($proj['status_color'] ?? ''); ?>">
              <span class="badge-label"><?php echo htmlspecialchars($proj['status_label'] ?? ''); ?></span>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

