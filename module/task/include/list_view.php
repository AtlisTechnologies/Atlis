<?php
// List view of tasks
?>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
        <th>Status</th>
        <th>Priority</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tasks as $task): ?>
        <tr>
          <td><?php echo htmlspecialchars($task['name']); ?></td>
          <td>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($task['status_color']); ?>">
              <span class="badge-label"><?php echo htmlspecialchars($task['status_label']); ?></span>
            </span>
          </td>
          <td><?php echo htmlspecialchars($task['priority_label']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
