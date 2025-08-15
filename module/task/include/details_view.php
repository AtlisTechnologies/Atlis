<?php
// Details view of a single task
?>
<?php if (!empty($current_task)): ?>
  <div class="card mb-4">
    <div class="card-body">
      <h3 class="mb-3"><?php echo h($current_task['name'] ?? ''); ?></h3>
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
            <div class="timeline-vertical mt-3">
              <?php foreach ($files as $f): ?>
                <div class="timeline-item position-relative">
                  <div class="row g-md-3">
                    <div class="col-12 col-md-auto d-flex">
                      <div class="timeline-item-date order-1 order-md-0 me-md-4">
                        <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                          <?php echo date('d M, Y', strtotime($f['date_created'])); ?><br class="d-none d-md-block" />
                          <?php echo date('h:i A', strtotime($f['date_created'])); ?>
                        </p>
                      </div>
                      <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                        <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                          <span class="fa-solid <?php echo strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file'; ?> text-primary-dark fs-10"></span>
                        </div>
                        <span class="timeline-bar border-end border-dashed"></span>
                      </div>
                    </div>
                    <div class="col">
                      <div class="timeline-item-content ps-6 ps-md-3">
                        <p class="mb-0"><a href="<?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a></p>
                        <p class="fs-9 text-body-secondary mb-0">
                          <?php echo h($f['file_size']); ?>
                          <span class="text-body-quaternary mx-1">|</span>
                          <?php echo h($f['file_type']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
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
            <div class="timeline-vertical mt-3">
              <?php foreach ($notes as $n): ?>
                <div class="timeline-item position-relative">
                  <div class="row g-md-3">
                    <div class="col-12 col-md-auto d-flex">
                      <div class="timeline-item-date order-1 order-md-0 me-md-4">
                        <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                          <?php echo date('d M, Y', strtotime($n['date_created'])); ?><br class="d-none d-md-block" />
                          <?php echo date('h:i A', strtotime($n['date_created'])); ?>
                        </p>
                      </div>
                      <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                        <div class="icon-item icon-item-sm rounded-7 shadow-none bg-success-subtle">
                          <span class="fa-solid fa-note-sticky text-success fs-10"></span>
                        </div>
                        <span class="timeline-bar border-end border-dashed"></span>
                      </div>
                    </div>
                    <div class="col">
                      <div class="timeline-item-content ps-6 ps-md-3">
                        <p class="mb-0"><?php echo nl2br(h($n['note_text'])); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
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
