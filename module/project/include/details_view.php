<?php
// Project details view built from the Phoenix theme project-details template
?>
<?php if (!empty($current_project)): ?>
<div class="content px-0 pt-navbar">
  <div class="row g-0">
    <div class="col-12 col-xxl-8 px-0 bg-body">
      <div class="px-4 px-lg-6 pt-6 pb-9">
        <div class="mb-5">
          <div class="d-flex justify-content-between">
            <h2 class="text-body-emphasis fw-bolder mb-2"><?php echo htmlspecialchars($current_project['name'] ?? ''); ?></h2>
          </div>
          <span class="badge badge-phoenix badge-phoenix-<?php echo htmlspecialchars($statusMap[$current_project['status']]['color_class'] ?? 'secondary'); ?>">
            <?php echo htmlspecialchars($statusMap[$current_project['status']]['label'] ?? ''); ?>
          </span>
        </div>
        <h3 class="text-body-emphasis mb-4">Project overview</h3>
        <p class="text-body-secondary mb-0"><?php echo nl2br(htmlspecialchars($current_project['description'] ?? '')); ?></p>
      </div>
    </div>
    <div class="col-12 col-xxl-4 px-0 border-start-xxl border-top-sm">
      <div class="bg-light dark__bg-gray-1100 h-100">
        <div class="p-4 p-lg-6">
          <h3 class="text-body-highlight mb-4 fw-bold">Notes</h3>
          <div class="timeline-vertical timeline-with-details">
            <?php if (!empty($notes)): ?>
              <?php foreach ($notes as $n): ?>
              <div class="timeline-item position-relative">
                <div class="row g-md-3">
                  <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                      <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                        <?php echo htmlspecialchars(date('d M, Y', strtotime($n['date_created']))); ?><br class="d-none d-md-block" />
                        <?php echo htmlspecialchars(date('h:i A', strtotime($n['date_created']))); ?>
                      </p>
                    </div>
                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                      <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                        <span class="fa-solid fa-note-sticky text-primary-dark fs-10"></span>
                      </div>
                      <span class="timeline-bar border-end border-dashed"></span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                      <p class="fs-9 text-body-secondary mb-0"><?php echo nl2br(htmlspecialchars($n['note_text'])); ?></p>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="fs-9 text-body-secondary mb-0">No notes found.</p>
            <?php endif; ?>
          </div>
          <div class="mt-4">
            <form action="functions/add_note.php" method="post">
              <input type="hidden" name="id" value="<?php echo (int)$current_project['id']; ?>">
              <div class="mb-3">
                <textarea class="form-control" name="note" rows="3" required></textarea>
              </div>
              <button class="btn btn-primary" type="submit">Add Note</button>
            </form>
          </div>
        </div>
        <div class="px-4 px-lg-6">
          <h4 class="mb-3">Files</h4>
        </div>
        <div class="border-top px-4 px-lg-6 py-4">
          <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)$current_project['id']; ?>">
            <input class="form-control mb-2" type="file" name="file" required>
            <button class="btn btn-primary" type="submit">Upload</button>
          </form>
          <?php if (!empty($files)): ?>
            <?php foreach ($files as $f): ?>
            <div class="border-top pt-3 mt-3">
              <div class="d-flex flex-between-center">
                <div class="d-flex mb-1">
                  <span class="fa-solid fa-file me-2 text-body-tertiary fs-9"></span>
                  <a class="text-body-highlight mb-0 lh-1" href="<?php echo htmlspecialchars($f['file_path']); ?>"><?php echo htmlspecialchars($f['file_name']); ?></a>
                </div>
              </div>
              <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap">
                <span><?php echo htmlspecialchars($f['file_size']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo htmlspecialchars($f['file_type']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo htmlspecialchars($f['date_created']); ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php else: ?>
<p>No project found.</p>
<?php endif; ?>
