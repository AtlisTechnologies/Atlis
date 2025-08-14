<?php
// Project details view built from the Phoenix theme project-details template
?>
<?php if (!empty($current_project)): ?>
  <div class="container-fluid py-4">
    <div class="row mb-4">
      <div class="col-12 col-lg-8">
        <h2 class="mb-2"><?php echo htmlspecialchars($current_project['name'] ?? ''); ?></h2>
        <div class="mb-2">
          <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo htmlspecialchars($statusMap[$current_project['status']]['color_class'] ?? 'secondary'); ?>">
            <span class="badge-label"><?php echo htmlspecialchars($statusMap[$current_project['status']]['label'] ?? ''); ?></span>
          </span>
        </div>
        <p class="text-body-secondary"><?php echo nl2br(htmlspecialchars($current_project['description'] ?? '')); ?></p>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12 col-xl-6">
        <div class="card mb-4">
          <div class="card-header"><h5 class="mb-0">Files</h5></div>
          <div class="card-body">
            <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
              <input type="hidden" name="id" value="<?php echo (int)$current_project['id']; ?>">
              <input class="form-control mb-2" type="file" name="file" required>
              <button class="btn btn-primary" type="submit">Upload</button>
            </form>
            <?php if (!empty($files)): ?>
              <div class="table-responsive">
                <table class="table table-sm">
                  <thead>
                    <tr><th>File</th><th>Size</th><th>Type</th></tr>
                  </thead>
                  <tbody>
                    <?php foreach ($files as $f): ?>
                      <tr>
                        <td><a href="<?php echo htmlspecialchars($f['file_path']); ?>"><?php echo htmlspecialchars($f['file_name']); ?></a></td>
                        <td><?php echo htmlspecialchars($f['file_size']); ?></td>
                        <td><?php echo htmlspecialchars($f['file_type']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-12 col-xl-6">
        <div class="card mb-4">
          <div class="card-header"><h5 class="mb-0">Notes</h5></div>
          <div class="card-body">
            <form action="functions/add_note.php" method="post" class="mb-3">
              <input type="hidden" name="id" value="<?php echo (int)$current_project['id']; ?>">
              <textarea class="form-control mb-2" name="note" rows="3" required></textarea>
              <button class="btn btn-primary" type="submit">Add Note</button>
            </form>
            <?php if (!empty($notes)): ?>
              <ul class="list-group">
                <?php foreach ($notes as $n): ?>
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div><?php echo nl2br(htmlspecialchars($n['note_text'])); ?></div>
                    <small class="text-muted ms-2"><?php echo htmlspecialchars($n['date_created']); ?></small>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <p>No project found.</p>
<?php endif; ?>

