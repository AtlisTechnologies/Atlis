<?php
// Div-based task list view using Phoenix todo-list structure
$completedCount = array_sum(array_column($tasks, 'completed'));
?>
<div class="mb-9" id="todoList" data-list='{"valueNames":["task-name","status","priority"]}'>
  <h2 class="mb-4">Tasks<span class="text-body-tertiary fw-normal">(Total: <span id="total-count"><?php echo count($tasks); ?></span> | Completed: <span id="completed-count"><?php echo $completedCount; ?></span>)</span></h2>
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
        <select class="form-select form-select-sm" id="filter-status">
          <option value="">All Statuses</option>
          <?php foreach ($statusMap as $status): ?>
            <option value="<?php echo h($status['label']); ?>"><?php echo h($status['label']); ?></option>
          <?php endforeach; ?>
        </select>
        <select class="form-select form-select-sm ms-2" id="filter-priority">
          <option value="">All Priorities</option>
          <?php foreach ($priorityMap as $priority): ?>
            <option value="<?php echo h($priority['label']); ?>"><?php echo h($priority['label']); ?></option>
          <?php endforeach; ?>
        </select>
        <select class="form-select form-select-sm ms-2" id="sort-select">
          <option value="task-name">Sort by Name</option>
          <option value="priority">Sort by Priority</option>
        </select>
      </div>
    </div>
    <div class="col-sm-auto ms-auto">
      <a href="index.php?action=create" class="btn btn-success btn-sm">New Task</a>
    </div>
  </div>
  <div class="mb-4 todo-list list">
    <?php foreach ($tasks as $task): ?>
      <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top task-row" data-task-id="<?php echo (int)$task['id']; ?>">
        <div class="col-auto">
          <button type="button" class="btn btn-warning btn-sm edit-task-btn me-2" data-task-id="<?php echo (int)$task['id']; ?>">Edit</button>
        </div>
        <div class="col-auto d-flex align-items-center fw-bold me-2">
          <?php echo (int)$task['id']; ?>
        </div>
        <div class="col-12 col-md flex-1 position-relative" style="z-index:1;">
          <div>
            <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
              <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-todo-<?php echo (int)$task['id']; ?>" data-task-id="<?php echo (int)$task['id']; ?>" data-original-status="<?php echo (int)$task['status']; ?>" <?php echo (!empty($task['completed']) ? 'checked' : ''); ?> onclick="event.stopPropagation();" />
              <span class="badge badge-phoenix fs-10 status-badge status badge-phoenix-<?php echo h($task['status_color'] ?? 'secondary'); ?> me-2"><?php echo h($task['status_label'] ?? ''); ?></span>
              <a href="index.php?action=details&amp;id=<?php echo (int)$task['id']; ?>" class="mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 fw-bold task-name-link task-name<?php echo (!empty($task['completed']) ? ' text-decoration-line-through' : ''); ?>"><?php echo h($task['name'] ?? ''); ?></a>
            </div>
            <span class="badge badge-phoenix fs-10 priority-badge priority badge-phoenix-<?php echo h($task['priority_color'] ?? 'secondary'); ?>"><?php echo h($task['priority_label'] ?? ''); ?></span>
            <?php $hierarchy = $task['project_name'] ?? $task['division_name'] ?? $task['agency_name'] ?? ''; ?>
            <?php if ($hierarchy): ?>
              <span class="badge badge-phoenix fs-10 badge-phoenix-dark me-2 ms-2"><?php echo h($hierarchy); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="modal fade" id="taskEditModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content"></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const todoList = new List('todoList', { valueNames: ['task-name', 'status', 'priority'] });

  const statusFilter = document.getElementById('filter-status');
  const priorityFilter = document.getElementById('filter-priority');
  const sortSelect = document.getElementById('sort-select');

  function applyFilters() {
    const s = statusFilter.value;
    const p = priorityFilter.value;
    todoList.filter(item => {
      const v = item.values();
      const statusMatch = !s || v.status === s;
      const priorityMatch = !p || v.priority === p;
      return statusMatch && priorityMatch;
    });
  }

  statusFilter.addEventListener('change', applyFilters);
  priorityFilter.addEventListener('change', applyFilters);

  sortSelect.addEventListener('change', function () {
    todoList.sort(this.value);
  });

  todoList.on('updated', function (list) {
    document.getElementById('total-count').textContent = list.matchingItems.length;
    const completed = list.matchingItems.filter(item => item.elm.querySelector('input[type="checkbox"]').checked).length;
    document.getElementById('completed-count').textContent = completed;
  });

  document.querySelectorAll('.todo-list input[type="checkbox"][data-task-id]').forEach(function (checkbox) {
    checkbox.addEventListener('click', function (event) {
      event.stopPropagation();
    });
    checkbox.addEventListener('change', function () {
      const taskId = this.dataset.taskId;
      const newState = this.checked ? 1 : 0;
      const originalStatus = this.dataset.originalStatus;
      const link = this.closest('.form-check').querySelector('.task-name-link');
      const badge = this.closest('.form-check').querySelector('.status-badge');
      fetch('functions/toggle_complete.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id: taskId, completed: newState, status: originalStatus })
      }).then(response => response.json())
        .then(data => {
          let isChecked = newState;
          if (data.success) {
            isChecked = data.completed == 1;
            if (badge && data.status_label && data.status_color) {
              badge.textContent = data.status_label;
              badge.className = `badge badge-phoenix fs-10 status-badge status badge-phoenix-${data.status_color} me-2`;
            }
            const item = todoList.items.find(i => i.elm.dataset.taskId === taskId);
            if (item && data.status_label) {
              item.values({ status: data.status_label });
            }
          } else {
            isChecked = !newState;
          }
          link.classList.toggle('text-decoration-line-through', isChecked);
          applyFilters();
          this.checked = isChecked;
        }).catch(() => {
          const isChecked = !newState;
          this.checked = isChecked;
          link.classList.toggle('text-decoration-line-through', isChecked);
        });
    });
  });

  document.querySelectorAll('.todo-list .edit-task-btn').forEach(function (btn) {
    btn.addEventListener('click', function (event) {
      event.stopPropagation();
      const id = this.dataset.taskId;
      fetch('index.php?action=create-edit&id=' + id + '&modal=1')
        .then(response => response.text())
        .then(html => {
          const modalEl = document.getElementById('taskEditModal');
          modalEl.querySelector('.modal-content').innerHTML = html;
          const form = modalEl.querySelector('form');
          if (form) { form.action = 'index.php?action=save'; }
          const modal = new bootstrap.Modal(modalEl);
          modal.show();
        });
    });
  });

  document.querySelectorAll('.todo-list .task-name-link').forEach(function (link) {
    link.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  });

  document.querySelectorAll('.status-select').forEach(function (select) {
    select.addEventListener('change', function () {
      const row = this.closest('.task-row');
      const taskId = row.dataset.taskId;
      fetch('functions/update_field.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id: taskId, field: 'status', value: this.value })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            const badge = row.querySelector('.status-badge');
            badge.textContent = data.label;
            badge.className = `badge badge-phoenix fs-10 status-badge status badge-phoenix-${data.color} me-2`;
            todoList.update();
          }
        });
    });
  });

  document.querySelectorAll('.priority-select').forEach(function (select) {
    select.addEventListener('change', function () {
      const row = this.closest('.task-row');
      const taskId = row.dataset.taskId;
      fetch('functions/update_field.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ id: taskId, field: 'priority', value: this.value })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            const badge = row.querySelector('.priority-badge');
            badge.textContent = data.label;
            badge.className = `badge badge-phoenix fs-10 priority-badge priority badge-phoenix-${data.color}`;
            todoList.update();
          }
        });
    });
  });
});
</script>
