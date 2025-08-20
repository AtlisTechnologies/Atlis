<?php
// Project details view built from the Phoenix theme project-details template
require_once __DIR__ . '/../../../includes/functions.php';

if (!empty($current_project)) {
    $totalTasks = count($tasks ?? []);
    $completedTasks = 0;
    $chartData = [];
    if (!empty($tasks)) {
        foreach ($tasks as $t) {
            if (!empty($t['completed'])) {
                $completedTasks++;
            }
            if (!empty($t['due_date'])) {
                $date = date('Y-m-d', strtotime($t['due_date']));
                if (!isset($chartData[$date])) {
                    $chartData[$date] = 0;
                }
                if (!empty($t['completed'])) {
                    $chartData[$date]++;
                }
            }
        }
    }
    ksort($chartData);
    $chartDates = array_keys($chartData);
    $chartValues = array_values($chartData);
    $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

    $timelineEvents = [];
    foreach ($tasks as $t) {
        if (!empty($t['completed']) && !empty($t['complete_date'])) {
            $timelineEvents[] = [
                'type' => 'task',
                'date' => $t['complete_date'],
                'name' => $t['name'] ?? ''
            ];
        }
    }
    foreach ($notes as $n) {
            $timelineEvents[] = [
                'type' => 'note',
                'date' => $n['date_created'] ?? '',
                'note_text' => $n['note_text'] ?? '',
                'user_name' => $n['user_name'] ?? '',
                'file_path' => $n['file_path'] ?? ''
            ];
    }
    usort($timelineEvents, function($a, $b) {
        return strtotime($b['date']) <=> strtotime($a['date']);
    });
}
?>
<?php if (!empty($current_project)): ?>
<div class="row">
  <div class="col-3 bg-body">
    <div class="">
      <div class="mb-5">
        <div class="d-flex justify-content-between">
          <h2 class="text-body-emphasis fw-bolder mb-2"><?= h($current_project['name'] ?? '') ?></h2>
        </div>
        <div class="dropdown d-inline me-2">
          <span class="badge badge-phoenix badge-phoenix-<?= h($statusMap[$current_project['status']]['color_class'] ?? 'secondary') ?> dropdown-toggle" id="statusBadge" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <?= h($statusMap[$current_project['status']]['label'] ?? '') ?>
          </span>
          <ul class="dropdown-menu" aria-labelledby="statusBadge">
            <?php foreach ($statusMap as $sid => $s): ?>
              <li><a class="dropdown-item project-field-option" href="#" data-field="status" data-value="<?= (int)$sid ?>" data-color="<?= h($s['color_class'] ?? 'secondary') ?>"><?= h($s['label'] ?? '') ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="dropdown d-inline">
          <span class="badge badge-phoenix badge-phoenix-<?= h($priorityMap[$current_project['priority']]['color_class'] ?? 'secondary') ?> dropdown-toggle" id="priorityBadge" data-bs-toggle="dropdown" role="button" aria-expanded="false">
            <?= h($priorityMap[$current_project['priority']]['label'] ?? '') ?>
          </span>
          <ul class="dropdown-menu" aria-labelledby="priorityBadge">
            <?php foreach ($priorityMap as $pid => $p): ?>
              <li><a class="dropdown-item project-field-option" href="#" data-field="priority" data-value="<?= (int)$pid ?>" data-color="<?= h($p['color_class'] ?? 'secondary') ?>"><?= h($p['label'] ?? '') ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>
      <div class="row gx-0 gx-sm-5 gy-8 mb-8">
        <div class="col-12 pe-xl-0">
          <div class="mb-4 mb-xl-7">

            <div class="row gx-0 gx-sm-7">
              <div class="col-12 col-sm-auto">
                <table class="lh-sm mb-4 mb-sm-0 mb-xl-4">
                  <tbody>
                    <tr>
                      <td class="py-1" colspan="2">
                        <div class="d-flex"><span class="fa-solid fa-earth-americas me-2 text-body-tertiary fs-9"></span>
                          <h5 class="text-body">Public project</h5>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td class="align-top py-1">
                        <div class="d-flex"><span class="fa-solid fa-user me-2 text-body-tertiary fs-9"></span>
                          <h5 class="text-body mb-0 text-nowrap">Agency :</h5>
                        </div>
                      </td>
                      <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="#!"><?= h($current_project['agency_name'] ?? '') ?></a></td>
                    </tr>
                    <tr>
                      <td class="align-top py-1">
                        <div class="d-flex"><span class="fa-solid fa-sitemap me-2 text-body-tertiary fs-9"></span>
                          <h5 class="text-body mb-0 text-nowrap">Division :</h5>
                        </div>
                      </td>
                      <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="#!"><?= h($current_project['division_name'] ?? '') ?></a></td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="col-6">
                    <table class="lh-sm">
                      <tbody>
                        <tr>
                          <td class="align-top py-1 text-body text-nowrap fw-bold">Started :</td>
                          <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                            <span id="startDateDisplay" data-field="start_date"><?= !empty($current_project['start_date']) ? h(date('jS M, Y', strtotime($current_project['start_date']))) : '' ?></span>
                            <input type="text" class="d-none" id="startDateInput" value="<?= !empty($current_project['start_date']) ? h(date('Y-m-d', strtotime($current_project['start_date']))) : '' ?>">
                          </td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-body text-nowrap fw-bold">Deadline :</td>
                          <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                            <span id="deadlineDisplay" data-field="complete_date"><?= !empty($current_project['complete_date']) ? h(date('jS M, Y', strtotime($current_project['complete_date']))) : '' ?></span>
                            <input type="text" class="d-none" id="deadlineInput" value="<?= !empty($current_project['complete_date']) ? h(date('Y-m-d', strtotime($current_project['complete_date']))) : '' ?>">
                          </td>
                        </tr>
                        <tr>
                          <td class="align-top py-1 text-body text-nowrap fw-bold">Progress :</td>
                          <td class="text-warning fw-semibold ps-3"><?= $progress ?>%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-6">
                    <div class="d-flex align-items-center mb-4">
                      <h4 class="text-body-emphasis mb-0 me-2">Assigned</h4>
                      <?php if (user_has_permission('project','create|update|delete')): ?>
                        <button class="bg-transparent border-0 text-success fs-9" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal" aria-label="Assign user">
                          <span class="fa-solid fa-plus"></span>
                        </button>
                      <?php endif; ?>
                    </div>
                    <?php if (!empty($assignedUsers)): ?>
                      <ul class="list-unstyled mb-4">
                        <?php foreach ($assignedUsers as $au): ?>
                          <li class="d-flex align-items-center mb-2">
                            <div class="avatar avatar-xl me-2">
                          <?php $pic = !empty($au['file_path']) ? $au['file_path'] : 'assets/img/team/avatar.webp'; ?>
                          <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir() . h($pic); ?>">
                            <img class="rounded-circle avatar avatar-m me-2" src="<?php echo getURLDir() . h($pic); ?>" alt="<?= h($au['name']) ?>" />
                          </a>
                            </div>
                            <div class="d-flex align-items-center flex-grow-1">
                              <h6 class="mb-0"><?= h($au['name']) ?></h6>
                              <?php if (user_has_permission('project','create|update|delete')): ?>
                                <form method="post" action="functions/remove_user.php" class="ms-2" onclick="return confirm('Remove this user?')">
                                  <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                                  <input type="hidden" name="user_id" value="<?= (int)$au['user_id'] ?>">
                                  <button class="bg-transparent border-0 text-danger fs-9" type="submit" aria-label="Unassign user">
                                    <span class="fa-solid fa-xmark"></span>
                                  </button>
                                </form>
                              <?php endif; ?>
                            </div>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                    <?php else: ?>
                      <p class="fs-9 text-body-secondary mb-4">No team members assigned.</p>
                    <?php endif; ?>
                  </div>
                </div>

                <hr>

                <div class="px-4 px-lg-6">
                  <h3 class="text-body-highlight fw-bold">Files</h3>
                </div>
                <?php if (user_has_permission('project','create|update|delete')): ?>
                <div class="px-4 px-lg-6 py-4">
                  <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="dropzone dropzone-multiple p-0" id="project-file-dropzone" data-dropzone="data-dropzone" data-options='{"url":"functions/upload_file.php"}'>
                    <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                    <input type="hidden" name="note_id" value="">
                    <div class="fallback">
                      <input type="file" name="file" multiple />
                    </div>
                    <div class="dz-message" data-dz-message="data-dz-message">
                      <div class="dz-message-text"><img class="me-2" src="<?php echo getURLDir(); ?>assets/img/icons/cloud-upload.svg" width="25" alt="" />Drop files here or click to upload</div>
                    </div>
                    <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
                      <div class="d-flex mb-3 pb-3 border-bottom border-translucent media">
                        <div class="border p-2 rounded-2 me-2">
                          <img class="rounded-2 dz-image" src="<?php echo getURLDir(); ?>assets/img/icons/file.png" alt="" data-dz-thumbnail="data-dz-thumbnail" />
                        </div>
                        <div class="flex-1 d-flex flex-between-center">
                          <div>
                            <h6 data-dz-name></h6>
                            <div class="d-flex align-items-center">
                              <p class="mb-0 fs-9 text-body-quaternary lh-1" data-dz-size></p>
                              <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                            </div>
                            <span class="fs-10 text-danger" data-dz-errormessage></span>
                          </div>
                          <div class="dropdown">
                            <button class="btn btn-link text-body-tertiary btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="fas fa-ellipsis-h"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end border border-translucent py-2">
                              <a class="dropdown-item" href="#!" data-dz-remove>Remove File</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <?php endif; ?>

                <?php if (!empty($files)):
                  $imageFiles = [];
                  $otherFiles = [];
                  foreach ($files as $f) {
                    if (strpos($f['file_type'], 'image/') === 0) {
                      $imageFiles[] = $f;
                    } else {
                      $otherFiles[] = $f;
                    }
                  }
                ?>
                  <?php if (!empty($imageFiles)): ?>
                    <div class="border-top px-4 px-lg-6 py-4">
                      <div class="row g-3">
                        <?php foreach ($imageFiles as $f): ?>
                          <div class="col-6 col-md-4 col-lg-3 position-relative">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>">
                              <img class="img-fluid rounded" src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>" alt="<?= h($f['file_name']) ?>">
                            </a>
                            <?php if ($is_admin || ($f['user_id'] ?? 0) == $this_user_id): ?>
                              <form action="functions/delete_file.php" method="post" class="position-absolute top-0 end-0 m-2" onsubmit="return confirm('Delete this file?');">
                                <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                                <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                                <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                              </form>

                            <?php endif; ?>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  <?php endif; ?>

                  <?php if (!empty($otherFiles)): ?>
                    <?php foreach ($otherFiles as $f): ?>
                      <div class="border-top px-4 px-lg-6 py-4">
                        <div class="me-n3">
                          <div class="d-flex flex-between-center">
                            <div class="d-flex mb-1"><span class="fa-solid fa-file me-2 text-body-tertiary fs-9"></span>
                              <p class="text-body-highlight mb-0 lh-1">
                                <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                              </p>
                            </div>
                            <?php if ($is_admin || ($f['user_id'] ?? 0) == $this_user_id): ?>
                              <form action="functions/delete_file.php" method="post" onsubmit="return confirm('Delete this file?');">
                                <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                                <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                                <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                              </form>
                            <?php endif; ?>
                          </div>

                          <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span><span class="text-body-quaternary mx-1">|</span><span class="text-nowrap">by <?= h($f['user_name'] ?? '') ?></span></div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>

                  <?php if (empty($imageFiles) && empty($otherFiles)): ?>
                    <div class="border-top px-4 px-lg-6 py-4">
                      <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
                    </div>
                  <?php endif; ?>
                <?php else: ?>
                  <div class="border-top px-4 px-lg-6 py-4">
                    <p class="fs-9 text-body-secondary mb-0">No files uploaded.</p>
                  </div>
                <?php endif; ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-9 bg-body">
    <h3 class="text-body-emphasis mb-4">Project overview</h3>
    <p class="text-body-secondary mb-4"><?= nl2br(h($current_project['description'] ?? '')) ?></p>
    <?php if (!empty($current_project['requirements']) || !empty($current_project['specifications'])): ?>
      <div class="row mb-5">
        <div class="col-md-6">
          <h4 class="mb-2 fs-8 text-body-emphasis">Requirements</h4>
          <p class="text-body-secondary mb-4"><?= nl2br(h($current_project['requirements'] ?? '')) ?></p>
        </div>
        <div class="col-md-6">
          <h4 class="mb-2 fs-8 text-body-emphasis">Specifications</h4>
          <p class="text-body-secondary mb-4"><?= nl2br(h($current_project['specifications'] ?? '')) ?></p>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-6 bg-light border-start border-top border-bottom">
        <div class="p-4" id="taskList" data-list='{"valueNames":["task-name","task-status","task-priority","task-due"],"page":10,"pagination":true}'>
          <h2 class="mb-4">Tasks<span class="text-body-tertiary fw-normal">(<?= count($tasks) ?>)</span></h2>
          <div class="row align-items-center g-3 mb-3">
            <div class="col-sm-auto">
              <div class="search-box">
                <form class="position-relative">
                  <input class="form-control search-input search" type="search" placeholder="Search tasks" aria-label="Search" />
                  <span class="fas fa-search search-box-icon"></span>
                </form>
              </div>
            </div>
            <div class="col-sm-auto">
              <div class="d-flex"><a class="btn btn-link p-0 ms-sm-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-filter me-1 fw-extra-bold fs-10"></span><?= count($tasks) ?> tasks</a><a class="btn btn-link p-0 ms-3 fs-9 text-body-tertiary fw-bold" href="#!"><span class="fas fa-sort me-1 fw-extra-bold fs-10"></span>Sorting</a></div>
            </div>
          </div>
          <form id="taskQuickAdd" class="d-flex mb-3">
            <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
            <input class="form-control me-2" type="text" name="name" placeholder="Quick add task" required>
            <button class="btn btn-success" type="submit">Add</button>
          </form>
          <div class="row g-2 mb-3">
            <div class="col-sm">
              <select class="form-select" id="assigneeFilter">
                <option value="">All Assignees</option>
                <?php foreach ($assignedUsers as $au): ?>
                  <option value="<?= (int)$au['user_id'] ?>"><?= h($au['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-sm">
              <select class="form-select" id="statusFilter">
                <option value="">All Statuses</option>
                <?php foreach ($taskStatusItems as $s): ?>
                  <option value="<?= (int)$s['id'] ?>"><?= h($s['label']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mb-4 todo-list list" id="taskListContainer">
            <?php if (!empty($tasks)): ?>
              <?php foreach ($tasks as $t): ?>
                <?php $overdue = (!empty($t['due_date']) && strtotime($t['due_date']) < time() && empty($t['completed'])); ?>
                <?php $assigneeIds = implode(',', array_column($t['assignees'] ?? [], 'assigned_user_id')); ?>
                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top task-row" data-task-id="<?= (int)$t['id'] ?>" data-assignee-ids="<?= h($assigneeIds) ?>" data-status-id="<?= (int)$t['status'] ?>">
                  <div class="col-12 col-md-auto flex-1">
                    <div>
                      <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
                        <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" id="checkbox-todo-<?= (int)$t['id'] ?>" data-task-id="<?= (int)$t['id'] ?>" <?= !empty($t['completed']) ? 'checked' : '' ?> />
                        <span class="me-2 badge badge-phoenix fs-10 task-status badge-phoenix-<?= h($t['status_color']) ?>" data-value="<?= (int)$t['status'] ?>"><?= h($t['status_label']) ?></span>
                        <span class="me-2 badge badge-phoenix fs-10 task-priority badge-phoenix-<?= h($t['priority_color']) ?>" data-value="<?= (int)$t['priority'] ?>"><?= h($t['priority_label']) ?></span>
                        <?php if (!empty($t['assignees'])): ?>
                          <?php foreach ($t['assignees'] as $a): ?>
                            <?php $apic = !empty($a['file_path']) ? $a['file_path'] : 'assets/img/team/avatar.webp'; ?>
                            <img src="<?php echo getURLDir() . h($apic); ?>" class="avatar avatar-m me-1 rounded-circle" title="<?= h($a['name']) ?>" alt="<?= h($a['name']) ?>" />
                          <?php endforeach; ?>
                        <?php else: ?>
                          <span class="fa-regular fa-user text-body-tertiary me-1"></span>
                        <?php endif; ?>
                        <a class="mb-0 fw-bold fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 task-name<?= !empty($t['completed']) ? ' text-decoration-line-through' : '' ?>" href="../task/index.php?action=details&id=<?= (int)$t['id'] ?>"><?= h($t['name']) ?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-auto">
                    <div class="d-flex ms-4 lh-1 align-items-center">
                      <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span><?= (int)($t['attachment_count'] ?? 0) ?></button>
                      <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0 task-due<?= $overdue ? ' text-danger' : '' ?>"><?= !empty($t['due_date']) ? h(date('d M, Y', strtotime($t['due_date']))) : '' ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="fs-9 text-body-secondary mb-0">No tasks found.</p>
            <?php endif; ?>
          </div>
          <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
            <div class="col-auto d-flex">
              <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
            </div>
            <div class="col-auto d-flex">
              <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
              <ul class="mb-0 pagination"></ul>
              <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-6 bg-light border">
        <div class="p-4 p-lg-6">
          <h3 class="text-body-highlight mb-4 fw-bold">Recent Activity</h3>
          <div class="timeline-vertical timeline-with-details" id="activityTimeline">
            <?php if (!empty($notes)): ?>
              <?php foreach ($notes as $n): ?>
              <div class="timeline-item position-relative" data-type="note">
                <div class="row g-md-3 mb-4">
                  <div class="col-12 col-md-auto d-flex">
                    <div class="timeline-item-date order-1 order-md-0 me-md-4">
                      <p class="fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end">
                        <?= h(date('d M, Y', strtotime($n['date_created']))) ?><br class="d-none d-md-block" />
                        <?= h(date('h:i A', strtotime($n['date_created']))) ?>
                      </p>
                    </div>
                    <div class="timeline-item-bar position-md-relative me-3 me-md-0">
                      <div class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle"><span class="fa-solid fa-note-sticky text-primary-dark fs-10"></span></div><span class="timeline-bar border-end border-dashed"></span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="timeline-item-content ps-6 ps-md-3">
                      <div class="border rounded-2 p-3">
                        <div class="d-flex">
                          <p class="fs-9 lh-sm mb-1 flex-grow-1 note-text" data-note-id="<?= (int)$n['id'] ?>"><?= nl2br(h($n['note_text'])) ?></p>
                          <?php if ($is_admin || ($n['user_id'] ?? 0) == $this_user_id): ?>
                          <form action="functions/delete_note.php" method="post" class="ms-2" onsubmit="return confirm('Delete this note?');">
                            <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                            <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                            <button class="btn btn-danger btn-sm" type="submit"><span class="fa-solid fa-trash"></span></button>
                          </form>
                          <?php endif; ?>
                        </div>
                        <?php if (!empty($noteFiles[$n['id']])): ?>
                          <ul class="list-unstyled mt-2">
                            <?php foreach ($noteFiles[$n['id']] as $f): ?>
                              <li class="mb-1">
                                <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                                  <p class="text-body-highlight mb-0 lh-1">
                                    <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                                      <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                                    <?php else: ?>
                                      <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                                    <?php endif; ?>
                                  </p>
                                </div>
                              </li>
                            <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>

                        <?php $npic = !empty($n['file_path']) ? $n['file_path'] : 'assets/img/team/avatar.webp'; ?>
                        <p class="fs-9 mb-0 d-flex align-items-center"><a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir() . h($npic); ?>"><img src="<?php echo getURLDir() . h($npic); ?>" class="rounded-circle avatar avatar-m me-2" alt="" /></a>by <a class="fw-semibold ms-1" href="#!"><?= h($n['user_name'] ?? '') ?></a></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="fs-9 text-body-secondary mb-0">No notes found.</p>
            <?php endif; ?>
          </div>
          <?php if (user_has_permission('project','create|update|delete')): ?>
          <div class="mt-4">
            <form action="functions/add_note.php" method="post" enctype="multipart/form-data" id="addNoteForm">
              <input type="hidden" name="id" value="<?= (int)$current_project['id'] ?>">
              <div class="mb-3">
                <textarea class="form-control" name="note" rows="3" placeholder="Add a new Note" required></textarea>
              </div>
              <div class="mb-3">
                <input class="form-control" type="file" name="files[]" multiple>
              </div>
                <center><button class="btn btn-success" type="submit">Add Note</button></center>
              </form>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Image preview</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" class="img-fluid" alt="Preview">
      </div>
    </div>
  </div>
</div>
<?php if (user_has_permission('project','create|update|delete')): ?>
<div class="modal fade" id="assignUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="functions/assign_user.php">
      <div class="modal-header">
        <h5 class="modal-title">Assign User</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
        <select class="form-select" name="user_id">
          <?php foreach ($availableUsers as $au): ?>
            <option value="<?= (int)$au['user_id'] ?>"><?= h($au['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Assign</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var projectId = <?= (int)$current_project['id'] ?>;
  if (window.Dropzone) {
    Dropzone.autoDiscover = false;
    const dz = new Dropzone('#project-file-dropzone', {
      url: 'functions/upload_file.php',
      paramName: 'file',
      init() {
        this.on('sending', (file, xhr, formData) => {
          formData.append('project_id', projectId);
          formData.append('note_id', '');
        });
        this.on('queuecomplete', () => {
          window.location.reload();
        });
      }
    });
  }
  var chartEl = document.querySelector('.echart-completed-task-chart');
  if (chartEl && window.echarts) {
    var chart = window.echarts.init(chartEl);
    var option = {
      tooltip: { trigger: 'axis' },
      xAxis: { type: 'category', data: <?= json_encode($chartDates ?? []) ?> },
      yAxis: { type: 'value' },
      series: [{ type: 'line', data: <?= json_encode($chartValues ?? []) ?>, smooth: true }]
    };
    chart.setOption(option);
  }
  var imageModal = document.getElementById('imageModal');
  if (imageModal) {
    imageModal.addEventListener('show.bs.modal', function (event) {
      var trigger = event.relatedTarget;
      var img = document.getElementById('modalImage');
      if (trigger && img) {
        img.src = trigger.getAttribute('data-img-src');
      }
    });
  }
  var statusOptions = <?= json_encode($taskStatusItems ?? []) ?>;
  var priorityOptions = <?= json_encode($taskPriorityItems ?? []) ?>;

  var assigneeFilter = document.getElementById('assigneeFilter');
  var statusFilter = document.getElementById('statusFilter');

  function applyTaskFilters(){
    var aVal = assigneeFilter ? assigneeFilter.value : '';
    var sVal = statusFilter ? statusFilter.value : '';
    document.querySelectorAll('.task-row').forEach(function(row){
      var show = true;
      if(aVal){
        var ids = row.dataset.assigneeIds ? row.dataset.assigneeIds.split(',') : [];
        if(ids.indexOf(aVal) === -1) show = false;
      }
      if(sVal && row.dataset.statusId !== sVal) show = false;
      row.classList.toggle('d-none', !show);
    });
  }
  if(assigneeFilter){ assigneeFilter.addEventListener('change', applyTaskFilters); }
  if(statusFilter){ statusFilter.addEventListener('change', applyTaskFilters); }

  var timelineButtons = document.querySelectorAll('.timeline-filter');
  var currentTimelineFilter = '';
  function applyTimelineFilter(){
    document.querySelectorAll('#activityTimeline .timeline-item').forEach(function(item){
      var hide = currentTimelineFilter && item.dataset.type !== currentTimelineFilter;
      item.classList.toggle('d-none', hide);
    });
  }
  timelineButtons.forEach(function(btn){
    btn.addEventListener('click', function(){
      timelineButtons.forEach(function(b){ b.classList.remove('active'); });
      this.classList.add('active');
      currentTimelineFilter = this.dataset.filter;
      applyTimelineFilter();
    });
  });
  applyTimelineFilter();

  var startSpan = document.getElementById('startDateDisplay');
  var startInput = document.getElementById('startDateInput');
  var deadlineSpan = document.getElementById('deadlineDisplay');
  var deadlineInput = document.getElementById('deadlineInput');

  function setupDateInline(span, input){
    if(!span || !input || !window.flatpickr) return;
    var field = span.getAttribute('data-field');
    var fp = flatpickr(input, {
      dateFormat: 'Y-m-d',
      defaultDate: input.value || null,
      onChange: function(selectedDates, dateStr){
        fetch('functions/update_field.php',{
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:new URLSearchParams({project_id: projectId, field: field, value: dateStr})
        }).then(r=>r.json()).then(function(d){
          if(d.success){
            span.textContent = dateStr ? new Date(dateStr).toLocaleDateString('en-US',{day:'numeric',month:'short',year:'numeric'}) : '';
          }
          span.classList.remove('d-none');
          input.classList.add('d-none');
        });
      }
    });
    span.addEventListener('click', function(){
      span.classList.add('d-none');
      input.classList.remove('d-none');
      fp.open();
    });
    input.addEventListener('blur', function(){
      span.classList.remove('d-none');
      input.classList.add('d-none');
    });
  }
  setupDateInline(startSpan, startInput);
  setupDateInline(deadlineSpan, deadlineInput);

  function htmlToElement(html){ var div=document.createElement('div'); div.innerHTML=html.trim(); return div.firstChild; }

  function renderTask(t){
    var overdue = t.due_date && !t.completed && new Date(t.due_date) < new Date();
    var assignees='';
    if(t.assignees){ t.assignees.forEach(function(a){ var pic = a.file_path ? '<?php echo getURLDir(); ?>'+a.file_path : '<?php echo getURLDir(); ?>assets/img/team/avatar.webp'; assignees += `<img src="${pic}" class="avatar avatar-m me-1 rounded-circle" title="${a.name}" alt="${a.name}" />`; }); }
    if(!assignees){ assignees = '<span class="fa-regular fa-user text-body-tertiary me-1"></span>'; }
    var assigneeIds = t.assignees ? t.assignees.map(function(a){ return a.assigned_user_id; }).join(',') : '';
    var due = t.due_date ? new Date(t.due_date).toLocaleDateString('en-US',{day:'2-digit',month:'short',year:'numeric'}) : '';
    return `<div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 border-top task-row" data-task-id="${t.id}" data-assignee-ids="${assigneeIds}" data-status-id="${t.status}">
      <div class="col-12 col-md-auto flex-1">
        <div>
          <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1 position-relative" style="z-index:1;">
            <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" data-task-id="${t.id}" ${t.completed ? 'checked' : ''} />
            <span class="me-2 badge badge-phoenix fs-10 task-status badge-phoenix-${t.status_color}" data-value="${t.status}">${t.status_label}</span>
            <span class="me-2 badge badge-phoenix fs-10 task-priority badge-phoenix-${t.priority_color}" data-value="${t.priority}">${t.priority_label}</span>
            ${assignees}
            <a class="mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 task-name${t.completed ? ' text-decoration-line-through' : ''}" href="../task/index.php?action=details&id=${t.id}">${t.name}</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-auto">
        <div class="d-flex ms-4 lh-1 align-items-center">
          <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span>${t.attachment_count || 0}</button>
          <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0 task-due${overdue ? ' text-danger':''}">${due}</p>
        </div>
      </div>
    </div>`;
  }

  function attachTaskEvents(row){
    var cb = row.querySelector('input[type="checkbox"][data-task-id]');
    if(cb){
      cb.addEventListener('change', function(){
        var params = new URLSearchParams({id: cb.dataset.taskId, completed: cb.checked ? 1 : 0});
        fetch('../task/functions/toggle_complete.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:params})
          .then(r=>r.json()).then(d=>{ if(d.success){ updateRow(row,d.task); } else { cb.checked=!cb.checked; } });
      });
    }
    row.querySelectorAll('.task-status,.task-priority').forEach(function(b){
      b.addEventListener('click', function(){
        var field = b.classList.contains('task-status') ? 'status':'priority';
        var opts = field==='status'?statusOptions:priorityOptions;
        var select=document.createElement('select');
        select.className='form-select form-select-sm';
        opts.forEach(function(o){ var op=document.createElement('option'); op.value=o.id; op.textContent=o.label; if(o.id==b.dataset.value) op.selected=true; select.appendChild(op); });
        b.replaceWith(select);
        select.focus();
        select.addEventListener('change', function(){
          var params=new URLSearchParams({id: row.dataset.taskId, field: field, value: this.value});
          fetch('../task/functions/update_field.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:params})
            .then(r=>r.json()).then(d=>{ if(d.success && d.task){ updateRow(row,d.task); } });
        });
        select.addEventListener('blur', function(){
          var span=document.createElement('span');
          span.className=b.className;
          span.dataset.value=b.dataset.value;
          span.textContent=b.textContent;
          select.replaceWith(span);
          attachTaskEvents(row);
        });
      });
    });
  }

  function updateRow(oldRow, task){
    if(task && task.id){
      var newEl = htmlToElement(renderTask(task));
      oldRow.replaceWith(newEl);
      attachTaskEvents(newEl);
      applyTaskFilters();
    }
  }

  document.querySelectorAll('.task-row').forEach(attachTaskEvents);
  applyTaskFilters();

  var addForm = document.getElementById('taskQuickAdd');
  if(addForm){
    addForm.addEventListener('submit', function(e){
      e.preventDefault();
      var fd = new FormData(addForm); fd.append('ajax',1);
      fetch('../task/functions/create.php',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
        if(d.success){
          var el = htmlToElement(renderTask(d.task));
          document.getElementById('taskListContainer').prepend(el);
          attachTaskEvents(el);
          addForm.reset();
          applyTaskFilters();
        }
      });
    });
  }

  var noteForm = document.getElementById('addNoteForm');
  if(noteForm){
    noteForm.addEventListener('submit', function(e){
      e.preventDefault();
      var fd=new FormData(noteForm);
      fetch('functions/add_note.php',{method:'POST',body:fd}).then(r=>r.json()).then(d=>{
        if(d.success){
          document.getElementById('activityTimeline').insertAdjacentHTML('afterbegin', renderNote(d.note));
          var newNote = document.getElementById('activityTimeline').querySelector('.note-text');
          attachNoteEvents(newNote);
          noteForm.reset();
          applyTimelineFilter();
        }
      });
    });
  }

  function renderNote(n){
    var files='';
    if(n.files){ n.files.forEach(function(f){ files += `<li class=\"mb-1\"><div class=\"d-flex mb-1\"><span class=\"fa-solid ${f.file_type.startsWith('image/')?'fa-image':'fa-file'} me-2 text-body-tertiary fs-9\"></span><p class=\"text-body-highlight mb-0 lh-1\"><a class=\"text-body-highlight\" href=\"#\" data-bs-toggle=\"modal\" data-bs-target=\"#imageModal\" data-img-src=\"<?php echo getURLDir(); ?>${f.file_path}\">${f.file_name}</a></p></div></li>`; }); if(files){ files = `<ul class=\"list-unstyled mt-2\">${files}</ul>`; } }
    return `<div class=\"timeline-item position-relative\" data-type=\"note\"><div class=\"row g-md-3 mb-4\"><div class=\"col-12 col-md-auto d-flex\"><div class=\"timeline-item-date order-1 order-md-0 me-md-4\"><p class=\"fs-10 fw-semibold text-body-tertiary text-opacity-85 text-end\">${n.date_created}</p></div><div class=\"timeline-item-bar position-md-relative me-3 me-md-0\"><div class=\"icon-item icon-item-sm rounded-7 shadow-none bg-primary-subtle\"><span class=\"fa-solid fa-note-sticky text-primary-dark fs-10\"></span></div><span class=\"timeline-bar border-end border-dashed\"></span></div></div><div class=\"col\"><div class=\"timeline-item-content ps-6 ps-md-3\"><div class=\"border rounded-2 p-3\"><div class=\"d-flex\"><p class=\"fs-9 lh-sm mb-1 flex-grow-1 note-text\" data-note-id=\"${n.id}\">${n.note_text.replace(/\n/g,'<br>')}</p></div>${files}<p class=\"fs-9 mb-0 d-flex align-items-center\"><img src=\"${n.file_path ? '<?php echo getURLDir(); ?>'+n.file_path : '<?php echo getURLDir(); ?>assets/img/team/avatar.webp'}\" class=\"rounded-circle avatar avatar-m me-2\" alt=\"\" />by <a class=\"fw-semibold ms-1\" href=\"#!\">${n.user_name??''}</a></p></div></div></div></div></div>`;
  }

  function attachNoteEvents(p){
    if(!p) return;
    p.addEventListener('click', function handler(){
      var id = this.dataset.noteId; var original = this.innerText; var textarea = document.createElement('textarea'); textarea.className='form-control'; textarea.value=original; this.replaceWith(textarea); textarea.focus(); textarea.addEventListener('blur', save); textarea.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); textarea.blur(); }});
      var self=this;
      function save(){
        fetch('functions/edit_note.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:new URLSearchParams({id:id, project_id:<?= (int)$current_project['id'] ?>, note:textarea.value})}).then(r=>r.json()).then(d=>{ var p=document.createElement('p'); p.className='fs-9 lh-sm mb-1 flex-grow-1 note-text'; p.dataset.noteId=id; p.innerHTML=d.note_text.replace(/\n/g,'<br>'); textarea.replaceWith(p); attachNoteEvents(p); });
      }
    });
  }
  document.querySelectorAll('.note-text').forEach(attachNoteEvents);
  document.querySelectorAll('.project-field-option').forEach(function(item){
    item.addEventListener('click', function(e){
      e.preventDefault();
      var field = this.dataset.field;
      var value = this.dataset.value;
      var color = this.dataset.color;
      fetch('functions/update_field.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ project_id: projectId, field: field, value: value })
      }).then(response => response.json())
        .then(data => {
          if (data.success) {
            var badge = document.getElementById(field + 'Badge');
            if (badge) {
              badge.textContent = this.textContent;
              badge.className = 'badge badge-phoenix badge-phoenix-' + color + ' dropdown-toggle';
            }
          }
        });
    });
  });
});
</script>
<?php else: ?>
<p>No project found.</p>
<?php endif; ?>
