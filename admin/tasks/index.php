<?php
require '../admin_header.php';
require_permission('admin_task','read');

$token = generate_csrf_token();


$sql = "SELECT t.id, t.name, 
               type.label AS type_label,
               cat.label AS category_label,
               sub.label AS sub_category_label,
               st.label AS status_label,
               pr.label AS priority_label
        FROM admin_task t
        LEFT JOIN lookup_list_items type ON t.type_id = type.id
        LEFT JOIN lookup_list_items cat ON t.category_id = cat.id
        LEFT JOIN lookup_list_items sub ON t.sub_category_id = sub.id
        LEFT JOIN lookup_list_items st ON t.status_id = st.id
        LEFT JOIN lookup_list_items pr ON t.priority_id = pr.id
        ORDER BY t.date_created DESC";
$tasks = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$types = get_lookup_items($pdo, 'ADMIN_TASK_TYPE');
$categories = get_lookup_items($pdo, 'ADMIN_TASK_CATEGORY');
$subcategories = get_lookup_items($pdo, 'ADMIN_TASK_SUB_CATEGORY');
$statuses = get_lookup_items($pdo, 'ADMIN_TASK_STATUS');
$priorities = get_lookup_items($pdo, 'ADMIN_TASK_PRIORITY');
$userStmt = $pdo->query('SELECT id, email FROM users ORDER BY email');
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Tasks</h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<div class="mb-3 d-flex gap-2">
  <?php if (user_has_permission('admin_task','create')): ?>
  <button class="btn btn-sm btn-success" id="addTaskBtn">Add Task</button>
  <form class="d-flex gap-2" method="post" action="functions/quick_add.php">
    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
    <input class="form-control form-control-sm" type="text" name="name" placeholder="Quick Add" required>
    <button class="btn btn-sm btn-primary" type="submit">Add</button>
  </form>
  <?php endif; ?>
</div>
<div id="tasks" data-list='{"valueNames":["id","name","type","category","subcategory","status","priority"],"page":25,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="type">Type</th>
          <th class="sort" data-sort="category">Category</th>
          <th class="sort" data-sort="subcategory">Sub Category</th>
          <th class="sort" data-sort="status">Status</th>
          <th class="sort" data-sort="priority">Priority</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach($tasks as $t): ?>
        <tr>
          <td class="id"><?= e($t['id']); ?></td>
          <td class="name"><?= e($t['name']); ?></td>
          <td class="type"><?= e($t['type_label']); ?></td>
          <td class="category"><?= e($t['category_label']); ?></td>
          <td class="subcategory"><?= e($t['sub_category_label']); ?></td>
          <td class="status"><?= e($t['status_label']); ?></td>
          <td class="priority"><?= e($t['priority_label']); ?></td>
          <td>
            <?php if (user_has_permission('admin_task', 'update')): ?>
            <a class="btn btn-sm btn-warning" href="task.php?id=<?= $t['id']; ?>">Edit</a>
            <?php endif; ?>
            <?php if (user_has_permission('admin_task','delete')): ?>
            <form method="post" action="functions/delete.php" class="d-inline" onsubmit="return confirm('Delete this task?');">
              <input type="hidden" name="id" value="<?= $t['id']; ?>">
              <input type="hidden" name="csrf_token" value="<?= $token; ?>">
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" id="taskForm">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="taskAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="task-id">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" id="task-name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" id="task-description" class="form-control" rows="3"></textarea>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Type</label>
            <select name="type_id" id="task-type" class="form-select">
              <option value="">--</option>
              <?php foreach ($types as $i): ?>
              <option value="<?= $i['id']; ?>"><?= e($i['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label class="form-label">Category</label>
            <select name="category_id" id="task-category" class="form-select">
              <option value="">--</option>
              <?php foreach ($categories as $i): ?>
              <option value="<?= $i['id']; ?>"><?= e($i['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label class="form-label">Sub Category</label>
            <select name="sub_category_id" id="task-subcategory" class="form-select">
              <option value="">--</option>
              <?php foreach ($subcategories as $i): ?>
              <option value="<?= $i['id']; ?>"><?= e($i['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Status</label>
            <select name="status_id" id="task-status" class="form-select">
              <option value="">--</option>
              <?php foreach ($statuses as $i): ?>
              <option value="<?= $i['id']; ?>"><?= e($i['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col">
            <label class="form-label">Priority</label>
            <select name="priority_id" id="task-priority" class="form-select">
              <option value="">--</option>
              <?php foreach ($priorities as $i): ?>
              <option value="<?= $i['id']; ?>"><?= e($i['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" id="task-start" class="form-control">
          </div>
          <div class="col">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" id="task-due" class="form-control">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Assign Users</label>
          <select name="assignments[]" id="task-assignments" class="form-select" multiple>
            <?php foreach ($users as $u): ?>
            <option value="<?= $u['id']; ?>"><?= e($u['email']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Memo</label>
          <textarea name="memo" id="task-memo" class="form-control" rows="2"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="taskSaveBtn">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrfToken = '<?= $token; ?>';
  const taskModal = new bootstrap.Modal(document.getElementById('taskModal'));
  const taskForm = document.getElementById('taskForm');
  const taskAlert = document.getElementById('taskAlert');
  const taskModalLabel = document.getElementById('taskModalLabel');
  const tasksTableBody = document.querySelector('#tasks tbody.list');
  const addTaskBtn = document.getElementById('addTaskBtn');
  const canDelete = <?= user_has_permission('admin_task','delete') ? 'true' : 'false'; ?>;
  let taskList;
  const options = JSON.parse(document.getElementById('tasks').dataset.list);
  if (window.List) {
    taskList = new window.List('tasks', options);
  }

  function showAlert(message, type = 'danger') {
    taskAlert.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
  }

  function escapeHtml(text = '') {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  addTaskBtn && addTaskBtn.addEventListener('click', () => {
    taskForm.reset();
    document.getElementById('task-id').value = '';
    taskAlert.innerHTML = '';
    taskModalLabel.textContent = 'Add Task';
    taskModal.show();
  });

  taskForm.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(taskForm);
    fetch('functions/create.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          const t = data.task;
          const tr = document.createElement('tr');
          let actions = `<a class="btn btn-sm btn-warning" href="task.php?id=${t.id}">Edit</a>`;
          if (canDelete) {
            actions += `<form method=\"post\" action=\"functions/delete.php\" class=\"d-inline\" onsubmit=\"return confirm('Delete this task?');\"><input type=\"hidden\" name=\"id\" value=\"${t.id}\"><input type=\"hidden\" name=\"csrf_token\" value=\"${csrfToken}\"><button class=\"btn btn-sm btn-danger\">Delete</button></form>`;
          }
          tr.innerHTML = `
            <td class="id">${escapeHtml(t.id)}</td>
            <td class="name">${escapeHtml(t.name)}</td>
            <td class="type">${escapeHtml(t.type_label || '')}</td>
            <td class="category">${escapeHtml(t.category_label || '')}</td>
            <td class="subcategory">${escapeHtml(t.sub_category_label || '')}</td>
            <td class="status">${escapeHtml(t.status_label || '')}</td>
            <td class="priority">${escapeHtml(t.priority_label || '')}</td>
            <td>${actions}</td>`;
          tasksTableBody.prepend(tr);
          if (taskList) { taskList.reIndex(); }
          taskModal.hide();
        } else {
          showAlert(data.error || 'Error');
        }
      })
      .catch(() => showAlert('Server error'));
  });
});
</script>
<?php require '../admin_footer.php'; ?>
