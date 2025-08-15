<?php
// Details view of a single task using Phoenix layout
require_once __DIR__ . '/../../../includes/functions.php';
?>
<?php if (!empty($current_task)): ?>
  <?php
    // Build hierarchy string
    $hierarchyParts = array_filter([
      $current_task['project_name'] ?? null,
      $current_task['division_name'] ?? null,
      $current_task['agency_name'] ?? null,
      $current_task['organization_name'] ?? null
    ]);

    // Merge notes and files into a single activity timeline
    $activities = [];
    if (!empty($files)) {
      foreach ($files as $f) {
        $f['type'] = 'file';
        $activities[] = $f;
      }
    }
    if (!empty($notes)) {
      foreach ($notes as $n) {
        $n['type'] = 'note';
        $activities[] = $n;
      }
    }
    usort($activities, function($a, $b) {
      return strtotime($b['date_created']) <=> strtotime($a['date_created']);
    });
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

  <div class="row g-0">
    <div class="col-12 col-xxl-8 px-0">
      <div class="p-4 p-lg-6">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Team members</h5>
            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal">Assign User</button>
          </div>
          <div class="card-body">
            <?php if (!empty($assignedUsers)): ?>
              <ul class="list-unstyled mb-0">
                <?php foreach ($assignedUsers as $au): ?>
                  <li class="d-flex align-items-center mb-2">
                    <div class="avatar avatar-xl me-2">
                      <img class="rounded-circle" src="<?php echo getURLDir(); ?>module/users/uploads/<?php echo h($au['profile_pic'] ?? ''); ?>" alt="<?php echo h($au['name']); ?>" />
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-0"><?php echo h($au['name']); ?></h6>
                    </div>
                    <form method="post" action="functions/remove_user.php" class="ms-2" onsubmit="return confirm('Remove this user?');">
                      <input type="hidden" name="task_id" value="<?php echo (int)$current_task['id']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo (int)$au['user_id']; ?>">
                      <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-minus"></span></button>
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
                <input type="hidden" name="task_id" value="<?php echo (int)$current_task['id']; ?>">
                <select class="form-select" name="user_id">
                  <?php foreach ($availableUsers as $au): ?>
                    <option value="<?php echo (int)$au['user_id']; ?>"><?php echo h($au['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="modal-footer">
                <button class="btn btn-success" type="submit">Assign</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-xxl-4 px-0 border-top-sm border-start-xxl">
      <div class="bg-light dark__bg-gray-1100 h-100">
        <div class="p-4 p-lg-6">
          <h3 class="text-body-highlight mb-4 fw-bold">Recent activity</h3>
          <form action="functions/add_note.php" method="post" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
            <div class="mb-2"><textarea class="form-control" name="note" rows="3" required></textarea></div>
            <button class="btn btn-success btn-sm" type="submit">Add Note</button>
          </form>
          <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
            <input type="hidden" name="id" value="<?php echo (int)($current_task['id'] ?? 0); ?>">
            <div class="mb-2"><input class="form-control form-control-sm" type="file" name="file" required></div>
            <button class="btn btn-success btn-sm" type="submit">Upload File</button>
          </form>
          <?php if (!empty($activities)): ?>
            <div class="timeline-vertical timeline-with-details">
              <?php foreach ($activities as $item): ?>
                <div class="timeline-item position-relative">
                  <div class="row g-md-3">
                    <div class="col-12 col-md-auto d-flex">
                      <div class="timeline-item-date order-1 order-md-0 me-md-4">
                        <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                          <?php echo date('d M, Y', strtotime($item['date_created'])); ?><br class="d-none d-md-block" />
                          <?php echo date('h:i A', strtotime($item['date_created'])); ?>
                        </p>
                      </div>
                      <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                        <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle">
                          <?php if ($item['type'] === 'note'): ?>
                            <span class="fa-solid fa-note-sticky text-primary-dark fs-10"></span>
                          <?php else: ?>
                            <span class="fa-solid <?php echo strpos($item['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file'; ?> text-primary-dark fs-10"></span>
                          <?php endif; ?>
                        </div>
                        <span class="timeline-bar border-end border-dashed"></span>
                      </div>
                    </div>
                    <div class="col">
                      <div class="timeline-item-content ps-6 ps-md-3">
                        <?php if ($item['type'] === 'note'): ?>
                          <p class="fs-9 lh-sm mb-1"><?php echo nl2br(h($item['note_text'])); ?></p>
                          <?php if (!empty($item['user_name'])): ?>
                            <p class="fs-9 mb-0">by <a class="fw-semibold" href="#!"><?php echo h($item['user_name']); ?></a></p>
                          <?php endif; ?>
                        <?php else: ?>
                          <p class="mb-0">
                            <?php if (strpos($item['file_type'], 'image/') === 0): ?>
                              <a href="#" data-bs-toggle="modal" data-bs-target="#fileModal-<?php echo (int)$item['id']; ?>"><?php echo h($item['file_name']); ?></a>
                              <div class="modal fade" id="fileModal-<?php echo (int)$item['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title"><?php echo h($item['file_name']); ?></h5>
                                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                      <img src="<?php echo getURLDir(); ?><?php echo h($item['file_path']); ?>" class="img-fluid" alt="<?php echo h($item['file_name']); ?>" />
                                    </div>
                                  </div>
                                </div>
                              </div>
                            <?php else: ?>
                              <a href="<?php echo getURLDir(); ?><?php echo h($item['file_path']); ?>"><?php echo h($item['file_name']); ?></a>
                            <?php endif; ?>
                          </p>
                          <p class="fs-9 text-body-secondary mb-0">
                            <?php echo h($item['file_size'] ?? ''); ?>
                            <?php if (!empty($item['file_type'])): ?>
                              <span class="text-body-quaternary mx-1">|</span>
                              <?php echo h($item['file_type']); ?>
                            <?php endif; ?>
                          </p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="fs-9 text-body-secondary mb-0">No recent activity.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php else: ?>
  <p>No task found.</p>
<?php endif; ?>
