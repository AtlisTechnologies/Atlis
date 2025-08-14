<?php
// Details view of a single task
?>
<?php if (!empty($current_task)): ?>
  <div class="card">
    <div class="card-body">
      <h3 class="mb-3"><?php echo htmlspecialchars($current_task['name'] ?? ''); ?></h3>
      <p class="mb-3">
        <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($statusMap[$current_task['status']]['color_class'] ?? 'secondary'); ?>">
          <span class="badge-label"><?php echo htmlspecialchars($statusMap[$current_task['status']]['label'] ?? ''); ?></span>
        </span>
        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary ms-1">
          <span class="badge-label"><?php echo htmlspecialchars($priorityMap[$current_task['priority']]['label'] ?? ''); ?></span>
        </span>
      </p>
      <p><?php echo nl2br(htmlspecialchars($current_task['description'] ?? '')); ?></p>
    </div>
  </div>
<?php else: ?>
  <p>No task found.</p>
<?php endif; ?>

