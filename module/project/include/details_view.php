<?php
require_once __DIR__ . '/../../../includes/functions.php';

if (empty($current_project)) {
    echo '<p class="text-danger">Project not found.</p>';
    return;
}

$totalTasks     = count($tasks ?? []);
$completedTasks = 0;
foreach ($tasks as $t) {
    if (!empty($t['completed'])) {
        $completedTasks++;
    }
}
$progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
?>
<div class="row g-0">
  <div class="col-12 col-xxl-8 px-0 bg-body">
    <div class="px-4 px-lg-6 pt-6 pb-6">
      <div class="d-flex justify-content-between mb-3">
        <h2 class="text-body-emphasis fw-bolder mb-0"><?= h($current_project['name']); ?></h2>
        <?php if (user_has_permission('project','update')): ?>
        <div class="d-flex gap-2">
          <a class="btn btn-warning btn-sm" href="index.php?action=create-edit&id=<?= (int)$current_project['id']; ?>">Edit</a>
          <form method="post" action="functions/delete.php" onsubmit="return confirm('Delete this project?');">
            <input type="hidden" name="id" value="<?= (int)$current_project['id']; ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
      <div class="mb-4">
        <span class="badge badge-phoenix badge-phoenix-<?= h($statusMap[$current_project['status']]['color_class'] ?? 'secondary'); ?>"><?= h($statusMap[$current_project['status']]['label'] ?? ''); ?></span>
        <span class="badge badge-phoenix badge-phoenix-<?= h($priorityMap[$current_project['priority']]['color_class'] ?? 'secondary'); ?>"><?= h($priorityMap[$current_project['priority']]['label'] ?? ''); ?></span>
      </div>
      <table class="table table-sm">
        <tbody>
          <tr>
            <th scope="row">Start date</th>
            <td><?= !empty($current_project['start_date']) ? h(date('jS M, Y', strtotime($current_project['start_date']))) : ''; ?></td>
          </tr>
          <tr>
            <th scope="row">Deadline</th>
            <td><?= !empty($current_project['complete_date']) ? h(date('jS M, Y', strtotime($current_project['complete_date']))) : ''; ?></td>
          </tr>
          <tr>
            <th scope="row">Progress</th>
            <td><?= $progress; ?>%</td>
          </tr>
        </tbody>
      </table>
      <h3 class="text-body-emphasis mt-5 mb-3">Project overview</h3>
      <p class="text-body-secondary mb-4"><?= nl2br(h($current_project['description'] ?? '')); ?></p>
      <?php if (!empty($current_project['requirements']) || !empty($current_project['specifications'])): ?>
      <div class="row mb-4">
        <div class="col-md-6">
          <h4 class="fs-8">Requirements</h4>
          <p class="text-body-secondary mb-3"><?= nl2br(h($current_project['requirements'] ?? '')); ?></p>
        </div>
        <div class="col-md-6">
          <h4 class="fs-8">Specifications</h4>
          <p class="text-body-secondary mb-3"><?= nl2br(h($current_project['specifications'] ?? '')); ?></p>
        </div>
      </div>
      <?php endif; ?>
    </div>
    <div class="px-4 px-lg-6 pb-6">
      <h4 class="mb-3">Tasks <span class="text-body-tertiary fw-normal">(<?= $totalTasks; ?>)</span></h4>
      <?php if (user_has_permission('task','create')): ?>
      <a class="btn btn-success mb-3" href="../task/index.php?action=create&project_id=<?= (int)$current_project['id']; ?>">Add Task</a>
      <?php endif; ?>
      <div class="mb-4">
        <?php foreach ($tasks as $t): ?>
        <div class="d-flex justify-content-between align-items-center border-top py-2">
          <div>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?= h($t['status_color']); ?>"><?= h($t['status_label']); ?></span>
            <span class="ms-2"><?= h($t['name']); ?></span>
          </div>
          <div class="d-flex align-items-center gap-1">
            <span class="text-body-tertiary fs-10 me-2"><?= !empty($t['due_date']) ? h(date('d M, Y', strtotime($t['due_date']))) : ''; ?></span>
            <?php if (user_has_permission('task','update')): ?>
            <a class="btn btn-warning btn-sm" href="../task/index.php?action=create-edit&id=<?= (int)$t['id']; ?>">Edit</a>
            <?php endif; ?>
            <?php if (user_has_permission('task','delete')): ?>
            <form method="post" action="../task/functions/delete.php" onsubmit="return confirm('Delete task?');" class="d-inline">
              <input type="hidden" name="id" value="<?= (int)$t['id']; ?>">
              <button class="btn btn-danger btn-sm" type="submit">Delete</button>
            </form>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if ($totalTasks === 0): ?><p class="text-body-secondary fs-9 mb-0">No tasks found.</p><?php endif; ?>
      </div>
    </div>
    <div class="px-4 px-lg-6 pb-6">
      <h4 class="mb-3">Files</h4>
      <?php if (user_has_permission('project','update')): ?>
      <button class="btn btn-success mb-3" data-bs-toggle="collapse" data-bs-target="#fileUpload">Add file</button>
      <div id="fileUpload" class="collapse mb-3">
        <form method="post" action="functions/upload_file.php" enctype="multipart/form-data" class="d-flex gap-2">
          <input type="hidden" name="project_id" value="<?= (int)$current_project['id']; ?>">
          <input class="form-control" type="file" name="file">
          <button class="btn atlis" type="submit">Upload</button>
        </form>
      </div>
      <?php endif; ?>
      <div class="row g-2">
        <?php foreach ($files as $f): ?>
        <div class="col-6 col-md-3">
          <a href="<?php echo getURLDir(); ?><?= h($f['file_path']); ?>" data-bs-toggle="modal" data-bs-target="#fileModal<?= (int)$f['id']; ?>">
            <img class="img-fluid rounded" src="<?php echo getURLDir(); ?><?= h($f['file_path']); ?>" alt="<?= h($f['file_name']); ?>">
          </a>
          <div class="modal fade" id="fileModal<?= (int)$f['id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-body">
                  <img class="img-fluid" src="<?php echo getURLDir(); ?><?= h($f['file_path']); ?>" alt="<?= h($f['file_name']); ?>">
                </div>
              </div>
            </div>
          </div>
          <?php if (user_has_permission('project','delete')): ?>
          <form method="post" action="functions/delete_file.php" onsubmit="return confirm('Delete file?');" class="mt-1">
            <input type="hidden" name="id" value="<?= (int)$f['id']; ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php if (empty($files)): ?><p class="text-body-secondary fs-9 mb-0">No files uploaded.</p><?php endif; ?>
      </div>
    </div>
    <div class="px-4 px-lg-6 pb-6">
      <h4 class="mb-3">Notes</h4>
      <?php if (user_has_permission('project','update')): ?>
      <button class="btn btn-success mb-3" data-bs-toggle="collapse" data-bs-target="#addNote">Add note</button>
      <div id="addNote" class="collapse mb-3">
        <form method="post" action="functions/add_note.php">
          <input type="hidden" name="project_id" value="<?= (int)$current_project['id']; ?>">
          <textarea class="form-control mb-2" name="note_text" rows="3"></textarea>
          <button class="btn atlis" type="submit">Save Note</button>
        </form>
      </div>
      <?php endif; ?>
      <ul class="list-unstyled mb-0">
        <?php foreach ($notes as $n): ?>
        <li class="mb-3">
          <div class="d-flex justify-content-between">
            <span><?= nl2br(h($n['note_text'])); ?></span>
            <small class="text-body-secondary ms-2">by <?= h($n['user_name'] ?? ''); ?></small>
          </div>
          <?php if (user_has_permission('project','delete')): ?>
          <form method="post" action="functions/delete_note.php" onsubmit="return confirm('Delete note?');" class="mt-1">
            <input type="hidden" name="id" value="<?= (int)$n['id']; ?>">
            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
          </form>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php if (empty($notes)): ?><li><p class="text-body-secondary fs-9 mb-0">No notes yet.</p></li><?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="col-12 col-xxl-4 bg-body-tertiary px-0">
    <div class="p-4">
      <h4 class="mb-3">Team members</h4>
      <?php if (user_has_permission('project','update')): ?>
      <button class="btn btn-success mb-3" data-bs-toggle="collapse" data-bs-target="#assignUser">Add member</button>
      <div id="assignUser" class="collapse mb-3">
        <form method="post" action="functions/assign_user.php" class="d-flex gap-2">
          <input type="hidden" name="project_id" value="<?= (int)$current_project['id']; ?>">
          <select class="form-select" name="user_id">
            <?php foreach ($availableUsers as $u): ?>
            <option value="<?= (int)$u['user_id']; ?>"><?= h($u['name']); ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn atlis" type="submit">Assign</button>
        </form>
      </div>
      <?php endif; ?>
      <ul class="list-unstyled mb-0">
        <?php foreach ($assignedUsers as $au): ?>
        <li class="d-flex align-items-center mb-2">
          <div class="avatar avatar-xl me-2">
            <img class="rounded-circle" src="<?php echo getURLDir(); ?>module/users/uploads/<?= h($au['profile_pic'] ?? ''); ?>" alt="<?= h($au['name']); ?>" />
          </div>
          <span class="flex-grow-1"><?= h($au['name']); ?></span>
          <?php if (user_has_permission('project','update')): ?>
          <form method="post" action="functions/remove_user.php" onsubmit="return confirm('Remove this user?');">
            <input type="hidden" name="project_id" value="<?= (int)$current_project['id']; ?>">
            <input type="hidden" name="user_id" value="<?= (int)$au['user_id']; ?>">
            <button class="btn btn-danger btn-sm" type="submit">Remove</button>
          </form>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php if (empty($assignedUsers)): ?><li><p class="text-body-secondary fs-9 mb-0">No team members assigned.</p></li><?php endif; ?>
      </ul>
    </div>
  </div>
</div>
