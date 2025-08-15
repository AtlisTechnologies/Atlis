<?php
// Div-based task list view using Phoenix todo-list structure
?>
<div class="mb-9">
  <h2 class="mb-4">Tasks<span class="text-body-tertiary fw-normal">(<?php echo count($tasks); ?>)</span></h2>
  <div class="row align-items-center g-3 mb-3">
    <div class="col-sm-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
    <div class="col-sm-auto">
      <div class="d-flex">
        <a class="btn btn-link p-0 ms-sm-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span><?php echo count($tasks); ?> tasks</a>
        <a class="btn btn-link p-0 ms-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</a>
      </div>
    </div>
    <div class="col-sm-auto ms-auto">
      <a href="index.php?action=create" class="btn btn-success btn-sm">New Task</a>
    </div>
  </div>
  <div class="mb-4 todo-list">
    <?php foreach ($tasks as $task): ?>
      <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 cursor-pointer border-top task-row" data-task-id="<?php echo (int)$task['id']; ?>">
        <div class="col-auto">
          <a href="index.php?action=edit&amp;id=<?php echo (int)$task['id']; ?>" class="btn btn-warning btn-sm edit-task-btn" data-event-propagation-prevent="data-event-propagation-prevent">Edit</a>
        </div>
        <div class="col-auto d-flex align-items-center"><span class="fs-8"><?php echo (int)$task['id']; ?></span></div>
        <div class="col-12 col-md flex-1 position-relative" style="z-index:1;">
          <div>
            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
              <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-todo-<?php echo (int)$task['id']; ?>" data-event-propagation-prevent="data-event-propagation-prevent" data-task-id="<?php echo (int)$task['id']; ?>" <?php echo (!empty($task['completed']) ? 'checked' : ''); ?> />
              <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 cursor-pointer<?php echo (!empty($task['completed']) ? ' text-decoration-line-through' : ''); ?>" for="checkbox-todo-<?php echo (int)$task['id']; ?>"><?php echo h($task['name'] ?? ''); ?></label>
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['status_color'] ?? 'secondary'); ?> me-2"><?php echo h($task['status_label'] ?? ''); ?></span>
              <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($task['priority_color'] ?? 'primary'); ?>"><?php echo h($task['priority_label'] ?? ''); ?></span>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.todo-list .task-row').forEach(function (row) {
    row.addEventListener('click', function () {
      const id = this.dataset.taskId;
      if (id) {
        window.location.href = 'index.php?action=details&id=' + id;
      }
    });
  });
  document.querySelectorAll('.todo-list input[type="checkbox"][data-task-id]').forEach(function (checkbox) {
    checkbox.addEventListener('click', function (event) {
      event.stopPropagation();
    });
    checkbox.addEventListener('change', function () {
      const taskId = this.dataset.taskId;
      const newState = this.checked ? 1 : 0;
      const label = this.nextElementSibling;
      fetch('functions/toggle_complete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id: taskId, completed: newState })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            this.checked = data.completed == 1;
          } else {
            this.checked = !newState;
          }
          label.classList.toggle('text-decoration-line-through', this.checked);
        }).catch(() => {
          this.checked = !newState;
          label.classList.toggle('text-decoration-line-through', this.checked);
        });
    });
  });
  document.querySelectorAll('.todo-list .edit-task-btn').forEach(function (btn) {
    btn.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });
  document.querySelectorAll('.todo-list .form-check-label').forEach(function (label) {
    label.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });
});
</script>

