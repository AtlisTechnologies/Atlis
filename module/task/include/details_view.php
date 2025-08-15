<?php
// Details view of a single task
require_once __DIR__ . '/../../../includes/functions.php';
?>
<?php if (!empty($current_task)): ?>
  <?php
    $hierarchyParts = array_filter([
      $current_task['project_name'] ?? null,
      $current_task['division_name'] ?? null,
      $current_task['agency_name'] ?? null,
      $current_task['organization_name'] ?? null
    ]);
  ?>
  <div class="mb-5">
    <div class="d-flex justify-content-between">
      <h2 class="text-body-emphasis fw-bolder mb-2"><?php echo h($current_task['name'] ?? ''); ?></h2>
    </div>
    <?php if ($hierarchyParts): ?>
      <p class="text-body-secondary mb-0"><?php echo implode(' / ', array_map('h', $hierarchyParts)); ?></p>
    <?php endif; ?>
    <p class="mb-3 mt-3">
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

  <div class="row">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Team members</h5>

          <button class="btn btn-sm btn-outline-atlis" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal">Assign User</button>

        </div>
        <div class="card-body">
          <?php if (!empty($assignedUsers)): ?>
            <ul class="list-unstyled mb-0">
              <?php foreach ($assignedUsers as $au): ?>
                <li class="d-flex align-items-center mb-2">
                  <div class="avatar avatar-xl me-2">
                    <img class="rounded-circle" src="<?php echo getURLDir(); ?>module/users/uploads/<?= h($au['profile_pic'] ?? '') ?>" alt="<?= h($au['name']) ?>" />
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-0"><?= h($au['name']) ?></h6>
                  </div>
                  <form method="post" action="functions/remove_user.php" class="ms-2" onclick="return confirm('Remove this user?')">
                    <input type="hidden" name="task_id" value="<?= (int)$current_task['id'] ?>">
                    <input type="hidden" name="user_id" value="<?= (int)$au['user_id'] ?>">
                    <button class="btn btn-link p-0 text-decoration-none text-danger" type="submit"><span class="fa-solid fa-minus"></span></button>
                  </form>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="mb-0 text-700 small">No team members assigned.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="modal fade" id="assignUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
          <form class="modal-content" method="post" action="functions/assign_user.php">
            <div class="modal-header">
              <h5 class="modal-title">Assign User</h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="task_id" value="<?= (int)$current_task['id'] ?>">
              <select class="form-select" name="user_id">
                <?php foreach ($availableUsers as $au): ?>
                  <option value="<?= (int)$au['user_id'] ?>"><?= h($au['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="modal-footer">
              <button class="btn btn-atlis" type="submit">Assign</button>
            </div>
          </form>
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
                        <p class="mb-0">
                          <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                            <a href="#" class="file-link" data-bs-toggle="modal" data-bs-target="#fileModal-<?php echo (int)$f['id']; ?>"><?php echo h($f['file_name']); ?></a>
                            <div class="modal fade" id="fileModal-<?php echo (int)$f['id']; ?>" tabindex="-1" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title"><?php echo h($f['file_name']); ?></h5>
                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-center">
                                    <img src="<?php echo getURLDir(); ?><?php echo h($f['file_path']); ?>" class="img-fluid" alt="<?php echo h($f['file_name']); ?>" />
                                  </div>
                                </div>
                              </div>
                            </div>
                          <?php else: ?>
                            <a href="<?php echo getURLDir(); ?><?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a>
                          <?php endif; ?>
                        </p>
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

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.file-link[data-bs-target]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var target = link.getAttribute('data-bs-target');
        var modalEl = document.querySelector(target);
        if (modalEl) {
          var modal = new bootstrap.Modal(modalEl);
          modal.show();
        }
      });
    });
  });
</script>
