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

$filesStmt = $pdo->prepare('SELECT id,file_name,file_path,file_size,file_type,date_created FROM module_projects_files WHERE project_id = :id ORDER BY date_created DESC');
$filesStmt->execute([':id' => $id]);
$files = $filesStmt->fetchAll(PDO::FETCH_ASSOC);

$tasksStmt = $pdo->prepare('SELECT id, name, status FROM module_tasks WHERE project_id = :id ORDER BY date_created DESC');
$tasksStmt->execute([':id' => $id]);
$tasks = $tasksStmt->fetchAll(PDO::FETCH_ASSOC);
$taskStatusMap = array_column(get_lookup_items($pdo, 'TASK_STATUS'), null, 'id');

$notesStmt = $pdo->prepare('SELECT id,note_text,date_created FROM module_projects_notes WHERE project_id = :id ORDER BY date_created DESC');
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
              <tr><th>File</th><th>Size</th><th>Type</th></tr>
            </thead>
            <tbody>
              <?php foreach ($files as $f): ?>
              <tr>
                <td><a href="<?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a></td>
                <td><?php echo h($f['file_size']); ?></td>
                <td><?php echo h($f['file_type']); ?></td>
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
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div><?php echo nl2br(h($n['note_text'])); ?></div>
            <small class="text-muted ms-2"><?php echo h($n['date_created']); ?></small>
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
