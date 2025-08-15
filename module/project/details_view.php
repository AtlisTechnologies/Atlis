<?php
require '../../includes/php_header.php';
require_permission('project','read');

$id = (int)($_GET['id'] ?? 0);
if(!$id){
  echo 'Invalid project ID';
  exit;
}

$stmt = $pdo->prepare('SELECT * FROM module_projects WHERE id = :id');
$stmt->execute([':id' => $id]);
$project = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$project){
  echo 'Project not found';
  exit;
}

$filesStmt = $pdo->prepare('SELECT id,user_id,file_name,file_path,file_size,file_type,date_created FROM module_projects_files WHERE project_id = :id ORDER BY date_created DESC');
$filesStmt->execute([':id' => $id]);
$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

$assignStmt = $pdo->prepare('SELECT u.id, u.email FROM module_projects_users pu JOIN users u ON pu.assigned_user_id = u.id WHERE pu.project_id = :id ORDER BY u.email');
$assignStmt->execute([':id' => $id]);
$assignedUsers = $assignStmt->fetchAll(PDO::FETCH_ASSOC);
$assignedUserIds = array_column($assignedUsers, 'id');
$allUsers = $pdo->query('SELECT id,email FROM users ORDER BY email')->fetchAll(PDO::FETCH_ASSOC);

$tasksStmt = $pdo->prepare('SELECT id, name, status FROM module_tasks WHERE project_id = :id ORDER BY date_created DESC');
$tasksStmt->execute([':id' => $id]);
$tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);
$taskStatusMap = array_column(get_lookup_items($pdo, 'TASK_STATUS'), null, 'id');

$notesStmt = $pdo->prepare('SELECT id,note_text,date_created,user_id FROM module_projects_notes WHERE project_id = :id ORDER BY date_created DESC');
$notesStmt->execute([':id' => $id]);
$notes = $notesStmt->fetchAll(PDO::FETCH_ASSOC);

require '../../includes/html_header.php';
?>
<main class="main" id="top">
  <?php require '../../includes/left_navigation.php'; ?>
  <?php require '../../includes/navigation.php'; ?>
  <div id="main_content" class="content">
    <h2 class="mb-4">Project: <?php echo h($project['name'] ?? ''); ?></h2>

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Assigned Users</h5>
        <?php if ($is_admin || $project['user_id'] == $this_user_id): ?>
        <form class="d-flex" action="functions/assign_user.php" method="post">
          <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
          <select name="user_id" class="form-select form-select-sm me-2">
            <?php foreach ($allUsers as $u): if (!in_array($u['id'], $assignedUserIds)): ?>
            <option value="<?php echo (int)$u['id']; ?>"><?php echo h($u['email']); ?></option>
            <?php endif; endforeach; ?>
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Assign</button>
        </form>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <?php if ($assignedUsers): ?>
        <ul class="list-group">
          <?php foreach ($assignedUsers as $u): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo h($u['email']); ?>
            <?php if ($is_admin || $project['user_id'] == $this_user_id): ?>
            <form action="functions/remove_user.php" method="post" class="d-inline">
              <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
              <input type="hidden" name="user_id" value="<?php echo (int)$u['id']; ?>">
              <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
            </form>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p class="mb-0">No users assigned.</p>
        <?php endif; ?>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Tasks</h5>
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">New Task</button>
      </div>
      <div class="card-body">
        <?php if ($tasks): ?>
        <ul class="list-group">
          <?php foreach ($tasks as $t): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="../task/details_view.php?id=<?php echo (int)($t['id'] ?? 0); ?>"><?php echo h($t['name'] ?? ''); ?></a>
            <?php $status = $taskStatusMap[$t['status']] ?? null; ?>
            <?php if ($status): ?>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($status['color_class']); ?>">
              <span class="badge-label"><?php echo h($status['label']); ?></span>
            </span>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php else: ?>
        <p class="mb-0">No tasks yet.</p>
        <?php endif; ?>
      </div>
    </div>

    <!-- New Task Modal -->
    <div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="../task/functions/create.php">
            <div class="modal-body">
              <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
              <?php if (!empty($project['agency_id'])): ?>
              <input type="hidden" name="agency_id" value="<?php echo (int)$project['agency_id']; ?>">
              <?php endif; ?>
              <?php if (!empty($project['division_id'])): ?>
              <input type="hidden" name="division_id" value="<?php echo (int)$project['division_id']; ?>">
              <?php endif; ?>
              <input type="hidden" name="redirect" value="details_view.php?id=<?php echo (int)$id; ?>">
              <div class="mb-3">
                <label class="form-label">Task Name</label>
                <input type="text" name="name" class="form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Upload Files</h5></div>
      <div class="card-body">
        <form action="functions/upload_file.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="mb-3">
            <input class="form-control" type="file" name="file" required>
          </div>
          <button class="btn btn-primary" type="submit">Upload</button>
        </form>
        <?php if ($files): ?>
        <div class="table-responsive mt-3">
          <table class="table table-sm">
            <thead>
              <tr><th>File</th><th>Size</th><th>Type</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php foreach ($files as $f): ?>
              <tr>
                <td><a href="<?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a></td>
                <td><?php echo h($f['file_size']); ?></td>
                <td><?php echo h($f['file_type']); ?></td>
                <td>
                  <?php if ($is_admin || $f['user_id'] == $this_user_id): ?>
                  <form action="functions/delete_file.php" method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo (int)$f['id']; ?>">
                    <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                  </form>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Notes</h5></div>
      <div class="card-body">
        <form action="functions/add_note.php" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="mb-3">
            <textarea class="form-control" name="note" rows="3" required></textarea>
          </div>
          <button class="btn btn-primary" type="submit">Add Note</button>
        </form>
        <?php if ($notes): ?>
        <ul class="list-group mt-3">
          <?php foreach ($notes as $n): ?>
          <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-start">
              <div><?php echo nl2br(h($n['note_text'])); ?></div>
              <div class="text-end ms-2">
                <small class="text-muted d-block mb-1"><?php echo h($n['date_created']); ?></small>
                <?php if ($is_admin || $n['user_id'] == $this_user_id): ?>
                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#editNote<?php echo (int)$n['id']; ?>">Edit</button>
                <form action="functions/delete_note.php" method="post" class="d-inline">
                  <input type="hidden" name="id" value="<?php echo (int)$n['id']; ?>">
                  <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
                  <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                </form>
                <?php endif; ?>
              </div>
            </div>
            <?php if ($is_admin || $n['user_id'] == $this_user_id): ?>
            <div class="collapse mt-2" id="editNote<?php echo (int)$n['id']; ?>">
              <form action="functions/edit_note.php" method="post">
                <input type="hidden" name="id" value="<?php echo (int)$n['id']; ?>">
                <input type="hidden" name="project_id" value="<?php echo (int)$id; ?>">
                <textarea class="form-control mb-2" name="note" rows="2"><?php echo h($n['note_text']); ?></textarea>
                <button class="btn btn-primary btn-sm" type="submit">Save</button>
              </form>
            </div>
            <?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>

    <?php require '../../includes/html_footer.php'; ?>
  </div>
</main>
<?php require '../../includes/js_footer.php'; ?>
