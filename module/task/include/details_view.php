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
      <span class="badge badge-phoenix fs-8 badge-phoenix-<?php echo h($statusMap[$current_task['status']]['color_class'] ?? 'secondary'); ?>">
        <span class="badge-label"><?php echo h($statusMap[$current_task['status']]['label'] ?? ''); ?></span>
      </span>
      <span class="badge badge-phoenix fs-8 badge-phoenix-<?php echo h($priorityMap[$current_task['priority']]['color_class'] ?? 'secondary'); ?>">
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

        <div class="px-4 px-lg-6"><h4 class="mb-3">Files</h4></div>
        <div class="border-top px-4 px-lg-6 py-4">
          <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
            <input class="form-control mb-2" type="file" name="file" required>
            <button class="btn btn-outline-atlis" type="submit">Upload</button>
          </form>
        </div>
        <?php if (!empty($files)): ?>
          <?php foreach ($files as $f): ?>
          <div class="border-top px-4 px-lg-6 py-4">
            <div class="me-n3">
              <div class="d-flex flex-between-center">
                <div class="d-flex mb-1"><span class="fa-solid <?php echo strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file'; ?> me-2 text-body-tertiary fs-9"></span>
                  <p class="text-body-highlight mb-0 lh-1"><a class="text-body-highlight" href="<? echo getURLDir(); ?><?php echo h($f['file_path']); ?>"><?php echo h($f['file_name']); ?></a></p>
                </div>
              </div>
              <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?php echo h($f['file_size']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo h($f['file_type']); ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?php echo h($f['date_created']); ?></span></div>
              <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                <img class="rounded-2 mt-2" src="<? echo getURLDir(); ?><?php echo h($f['file_path']); ?>" alt="" style="width:320px" />
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="border-top px-4 px-lg-6 py-4">
            <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
          </div>
        <?php endif; ?>
    </div>

    <div class="col-lg-8">
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
                        <?php echo date('d M, Y', strtotime($n['date_created'])); ?><br class="d-none d-md-block" />
                        <?php echo date('h:i A', strtotime($n['date_created'])); ?>
                      </p>
                    </div>
                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                      <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-note-sticky text-primary-dark fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                      <p class="fs-9 lh-sm mb-1"><?php echo nl2br(h($n['note_text'])); ?></p>
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
              <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
              <div class="mb-3">
                <textarea class="form-control" name="note" rows="3" required></textarea>
              </div>
              <button class="btn btn-atlis" type="submit">Add Note</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <p>No task found.</p>
<?php endif; ?>
