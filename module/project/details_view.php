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
