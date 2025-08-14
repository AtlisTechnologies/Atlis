<?php
// Project details view built from the Phoenix theme project-details template
require_once __DIR__ . '/../../../includes/functions.php';
?>
<?php if (!empty($current_project)): ?>
<div class="content px-0 pt-navbar">
  <div class="row g-0">
    <div class="col-12 col-xxl-8 px-0 bg-body">
      <div class="px-4 px-lg-6 pt-6 pb-9">
        <div class="mb-5">
          <div class="d-flex justify-content-between">
            <h2 class="text-body-emphasis fw-bolder mb-2"><?php echo h($current_project['name'] ?? ''); ?></h2>
          </div>
          <span class="badge badge-phoenix badge-phoenix-<?php echo h($statusMap[$current_project['status']]['color_class'] ?? 'secondary'); ?>">
            <?php echo h($statusMap[$current_project['status']]['label'] ?? ''); ?>
          </span>
        </div>
          <h3 class="text-body-emphasis mb-4">Project overview</h3>
          <p class="text-body-secondary mb-4"><?php echo nl2br(h($current_project['description'] ?? '')); ?></p>

          <h3 class="text-body-emphasis mb-4">Tasks</h3>
          <div class="row align-items-center g-0 justify-content-start mb-3">
            <div class="col-12 col-sm-auto">
              <div class="search-box w-100 mb-2 mb-sm-0" style="max-width:30rem;">
                <form class="position-relative">
                  <input class="form-control search-input" type="search" placeholder="Search tasks" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
            <div class="col-auto d-flex">
              <p class="mb-0 ms-sm-3 fs-9 text-body-tertiary fw-bold"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span><?php echo count($tasks ?? []); ?> tasks</p>
            </div>
          </div>
          <?php if (!empty($tasks)): ?>
            <?php foreach ($tasks as $t): ?>
            <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top">
              <div class="col-12 col-lg-auto flex-1">
                <div>
                  <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                    <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-task-<?php echo (int)$t['id']; ?>" <?php echo !empty($t['completed']) ? 'checked' : ''; ?> />
                    <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-task-<?php echo (int)$t['id']; ?>"><?php echo h($t['name']); ?></label>
                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($t['status_color'] ?? 'secondary'); ?> ms-2"><span class="badge-label"><?php echo h($t['status_label'] ?? ''); ?></span></span>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-auto">
                <div class="d-flex ms-4 lh-1 align-items-center">
                  <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-lg-3 mb-0"><?php echo !empty($t['due_date']) ? h(date('d M, Y', strtotime($t['due_date']))) : ''; ?></p>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="fs-9 text-body-secondary mb-0">No tasks found.</p>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-12 col-xxl-4 px-0 border-start-xxl border-top-sm">
        <div class="bg-light dark__bg-gray-1100 h-100">
        <div class="p-4 p-lg-6">
          <h3 class="text-body-highlight mb-4 fw-bold">Recent activity</h3>
          <div class="timeline-vertical timeline-with-details">
            <?php if (!empty($notes)): ?>
              <?php foreach ($notes as $n): ?>
              <div class="timeline-item position-relative">
                <div class="row g-md-3">
                  <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                      <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                        <?php echo h(date('d M, Y', strtotime($n['date_created']))); ?><br class="d-none d-md-block" />
                        <?php echo h(date('h:i A', strtotime($n['date_created']))); ?>
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
                        <p class="fs-9 text-body-secondary mb-1"><?php echo nl2br(h($n['note_text'])); ?></p>
                        <p class="fs-9 mb-0">by <a class="fw-semibold" href="#!"><?php echo h($n['user_name'] ?? ''); ?></a></p>
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
          </div>
          <?php if (!empty($files)): ?>
            <?php foreach ($files as $f): ?>
            <div class="border-top px-4 px-lg-6 py-4">
              <div class="d-flex flex-between-center">
                <div class="d-flex mb-1">
                  <span class="fa-solid <?php echo strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file'; ?> me-2 text-body-tertiary fs-9"></span>
                  <a class="text-body-highlight mb-0 lh-1" href="<?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a>
                </div>
              </div>
              <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap">
                <span><?php echo h($f['file_size']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo h($f['file_type']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo h($f['date_created']); ?></span>
              </div>
              <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                <img class="rounded-2 mt-2" src="<?php echo h($f['file_path']); ?>" alt="" style="width:320px" />
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="border-top px-4 px-lg-6 py-4">
              <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
<p>No project found.</p>
<?php endif; ?>
