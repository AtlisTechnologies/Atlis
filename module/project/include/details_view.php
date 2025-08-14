<?php
// Details view of a single project
?>
<?php if (!empty($current_project)): ?>
  <div class="card">
    <div class="card-body">
      <h3 class="mb-3"><?php echo htmlspecialchars($current_project['name'] ?? ''); ?></h3>
      <p class="mb-3">
        <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($statusMap[$current_project['status']]['color_class'] ?? 'secondary'); ?>">
          <span class="badge-label"><?php echo htmlspecialchars($statusMap[$current_project['status']]['label'] ?? ''); ?></span>
        </span>
      </p>
      <p><?php echo nl2br(htmlspecialchars($current_project['description'] ?? '')); ?></p>
    </div>
  </div>
<?php else: ?>
  <p>No project found.</p>
<?php endif; ?>

