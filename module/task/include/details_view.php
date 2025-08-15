<?php
// Details view of a single task
?>
<?php if (!empty($current_task)): ?>
  <?php
    $hierarchyParts = array_filter([
      $project_name ?? null,
      $division_name ?? null,
      $agency_name ?? null,
      $organization_name ?? null
    ]);
    $hierarchyString = implode(' / ', array_map('h', $hierarchyParts));
  ?>
  <div class="card mb-4">
    <div class="card-body">
      <h3 class="mb-3">
        <?php echo h($current_task['name'] ?? ''); ?>
        <?php if ($hierarchyString !== ''): ?>
          &ndash; <?php echo $hierarchyString; ?>
        <?php endif; ?>
      </h3>
      <p class="mb-3">
        <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($statusMap[$current_task['status']]['color_class'] ?? 'secondary'); ?>">
          <span class="badge-label"><?php echo h($statusMap[$current_task['status']]['label'] ?? ''); ?></span>
        </span>
        <span class="badge badge-phoenix fs-10 badge-phoenix-secondary ms-1">
          <span class="badge-label"><?php echo h($priorityMap[$current_task['priority']]['label'] ?? ''); ?></span>
        </span>
      </p>
      <?php if (!empty($current_task['description'])): ?>
      <p><?php echo nl2br(h($current_task['description'])); ?></p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Assignments</h5></div>
        <div class="card-body">
          <?php if (!empty($assignments)): ?>
            <ul class="list-unstyled mb-0">
              <?php foreach ($assignments as $assign): ?>
                <li class="mb-1"><span class="fas fa-user text-primary"></span> <?php echo h($assign['email']); ?></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="mb-0 text-700 small">No assignments</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Files</h5></div>
        <div class="card-body">
          <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
            <div class="mb-2"><input class="form-control form-control-sm" type="file" name="file" required></div>
            <button class="btn btn-sm btn-primary" type="submit">Upload</button>
          </form>
          <?php if (!empty($files)): ?>
            <ul class="list-unstyled mb-0">
              <?php foreach ($files as $f): ?>
                <li class="mb-1"><a href="<?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a></li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="mb-0 text-700 small">No files</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header"><h5 class="mb-0">Notes</h5></div>
        <div class="card-body">
          <form action="functions/add_note.php" method="post" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
            <div class="mb-2"><textarea class="form-control" name="note" rows="3" required></textarea></div>
            <button class="btn btn-sm btn-primary" type="submit">Add Note</button>
          </form>
          <?php if (!empty($notes)): ?>
            <ul class="list-group">
              <?php foreach ($notes as $n): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div><?php echo nl2br(h($n['note_text'])); ?></div>
                  <small class="text-muted ms-2"><?php echo h($n['date_created']); ?></small>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="mb-0 text-700 small">No notes</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <p>No task found.</p>
<?php endif; ?>
