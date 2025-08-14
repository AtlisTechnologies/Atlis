<?php
// List view of tasks
?>
<div class="d-flex justify-content-end mb-3">
  <a href="index.php?action=create" class="btn btn-primary btn-sm">New Task</a>
 </div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Priority</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tasks as $task): ?>
        <tr>
          <td><a href="index.php?action=details&amp;id=<?php echo (int)($task['id'] ?? 0); ?>"><?php echo htmlspecialchars($task['name'] ?? ''); ?></a></td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($task['status_color'] ?? ''); ?>">
              <span class="badge-label"><?php echo htmlspecialchars($task['status_label'] ?? ''); ?></span>
            </span>
          </td>
          <td><?php echo htmlspecialchars($task['priority_label'] ?? ''); ?></td>
          <td><a href="index.php?action=edit&amp;id=<?php echo (int)($task['id'] ?? 0); ?>" class="btn btn-sm btn-link">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
