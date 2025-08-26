<?php
require '../admin_header.php';
require_permission('admin_task','read');

$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;

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
?>
<h2 class="mb-4">Tasks</h2>
<div class="mb-3 d-flex gap-2">
  <?php if (user_has_permission('admin_task','create')): ?>
  <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#taskModal">Add Task</button>
  <?php endif; ?>
  <?php if (user_has_permission('admin_task','create')): ?>
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
            <a class="btn btn-sm btn-warning" href="task.php?id=<?= $t['id']; ?>">Edit</a>
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
    <div class="modal-content">
      <div class="modal-body p-0">
        <iframe src="task.php" class="w-100" style="height:600px;border:0"></iframe>
      </div>
    </div>
  </div>
</div>
<?php require '../admin_footer.php'; ?>
