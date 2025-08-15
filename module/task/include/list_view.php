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
          <td><a href="index.php?action=details&amp;id=<?php echo (int)($task['id'] ?? 0); ?>"><?php echo h($task['name'] ?? ''); ?></a></td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['status_color'] ?? ''); ?>">
              <span class="badge-label"><?php echo h($task['status_label'] ?? ''); ?></span>
            </span>
          </td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['priority_color'] ?? ''); ?>">
              <span class="badge-label"><?php echo h($task['priority_label'] ?? ''); ?></span>
            </span>
          </td>
          <td><a href="index.php?action=edit&amp;id=<?php echo (int)($task['id'] ?? 0); ?>" class="btn btn-sm btn-link">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
