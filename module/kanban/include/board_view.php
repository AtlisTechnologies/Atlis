<?php
// Expects $board and $statuses from index.php
?>
<div class="container py-4">
  <h2 class="mb-4"><?= htmlspecialchars($board['name'] ?? 'Board') ?></h2>
  <div class="row g-3 kanban-board" data-board-id="<?= $board['id'] ?>">
    <?php foreach ($statuses as $st): 
      $tasks = fetch_tasks_for_status($pdo, $st['name']);
    ?>
    <div class="col-md-3">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0"><?= htmlspecialchars($st['name']) ?></h5>
        </div>
        <div class="card-body min-vh-50 kanban-column" data-status="<?= htmlspecialchars($st['name']) ?>">
          <?php foreach ($tasks as $t): ?>
            <div class="card mb-2 p-2 kanban-item" data-task-id="<?= $t['id'] ?>" draggable="true">
              <?= htmlspecialchars($t['name']) ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
<script>
document.querySelectorAll('.kanban-item').forEach(item => {
  item.addEventListener('dragstart', e => {
    e.dataTransfer.setData('text/plain', item.dataset.taskId);
  });
});

document.querySelectorAll('.kanban-column').forEach(col => {
  col.addEventListener('dragover', e => e.preventDefault());
  col.addEventListener('drop', function(e) {
    e.preventDefault();
    const taskId = e.dataTransfer.getData('text/plain');
    const status = this.dataset.status;
    fetch('functions/update_task_status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `task_id=${taskId}&status=${encodeURIComponent(status)}`
    });
    const item = document.querySelector(`.kanban-item[data-task-id="${taskId}"]`);
    if (item) this.appendChild(item);
  });
});
</script>
