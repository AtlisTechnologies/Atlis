<?php
// Details view of a single task
require_once __DIR__ . '/../../../includes/functions.php';
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
