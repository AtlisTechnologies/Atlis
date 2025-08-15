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
}
?>
<?php if (!empty($current_project)): ?>
<div class="row g-0">
  <div class="col-12 col-xxl-8 px-0 bg-body">
    <div class="px-4 px-lg-6 pt-6 pb-9">
      <div class="mb-5">
        <div class="d-flex justify-content-between">
          <h2 class="text-body-emphasis fw-bolder mb-2"><?= h($current_project['name'] ?? '') ?></h2>
          <div class="btn-reveal-trigger">
            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h"></span></button>
            <div class="dropdown-menu dropdown-menu-end py-2"><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item text-danger" href="#!">Delete</a><a class="dropdown-item" href="#!">Download</a><a class="dropdown-item" href="#!">Report abuse</a></div>
          </div>
        </div>
        <span class="badge badge-phoenix badge-phoenix-<?= h($statusMap[$current_project['status']]['color_class'] ?? 'secondary') ?>">
          <?= h($statusMap[$current_project['status']]['label'] ?? '') ?>
        </span>
        <span class="badge badge-phoenix badge-phoenix-<?= h($priorityMap[$current_project['priority']]['color_class'] ?? 'secondary') ?>">
          <?= h($priorityMap[$current_project['priority']]['label'] ?? '') ?>
        </span>
      </div>
      <div class="row gx-0 gx-sm-5 gy-8 mb-8">
        <div class="col-12 col-xl-3 col-xxl-4 pe-xl-0">
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
                          <h5 class="text-body mb-0 text-nowrap">Client :</h5>
                        </div>
                      </td>
                      <td class="ps-1 py-1"><a class="fw-semibold d-block lh-sm" href="#!"><?= h($current_project['agency_id'] ?? '') ?></a></td>
                    </tr>
                    <tr>
                      <td class="align-top py-1">
                        <div class="d-flex"><span class="fa-regular fa-credit-card me-2 text-body-tertiary fs-9"></span>
                          <h5 class="text-body mb-0 text-nowrap">Budget : </h5>
                        </div>
                      </td>
                      <td class="fw-bold ps-1 py-1 text-body-highlight"><?= h($current_project['budget'] ?? '') ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="col-12 col-sm-auto">
                <table class="lh-sm">
                  <tbody>
                    <tr>
                      <td class="align-top py-1 text-body text-nowrap fw-bold">Started : </td>
                      <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3"><?= !empty($current_project['start_date']) ? h(date('jS M, Y', strtotime($current_project['start_date']))) : '' ?></td>
                    </tr>
                    <tr>
                      <td class="align-top py-1 text-body text-nowrap fw-bold">Deadline :</td>
                      <td class="text-body-tertiary text-opacity-85 fw-semibold ps-3"><?= !empty($current_project['complete_date']) ? h(date('jS M, Y', strtotime($current_project['complete_date']))) : '' ?></td>
                    </tr>
                    <tr>
                      <td class="align-top py-1 text-body text-nowrap fw-bold">Progress :</td>
                      <td class="text-warning fw-semibold ps-3"><?= $progress ?>%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div>
            <div class="d-flex align-items-center"><span class="fa-solid fa-list-check me-2 text-body-tertiary fs-9"></span>
              <h5 class="text-body-emphasis mb-0 me-2"><?= $totalTasks ?><span class="text-body fw-normal ms-2">tasks</span></h5><a class="fw-bold fs-9 mt-1" href="../task/index.php?action=list&project_id=<?= (int)$current_project['id'] ?>">See tasks <span class="fa-solid fa-chevron-right me-2 fs-10"></span></a>
            </div>
          </div>
        </div>
        <div class="col-12 col-xl-9 col-xxl-8">
          <div class="row flex-between-center mb-3 g-3">
            <div class="col-auto">
              <h4 class="text-body-emphasis">Task completed over time</h4>
              <p class="text-body-tertiary mb-0">Hard works done across all tasks</p>
            </div>
          </div>
            <div class="echart-completed-task-chart" style="min-height:200px;width:100%"></div>
        </div>
      </div>
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
    </div>
    <div class="row">
      <div class="col-4">
        <div class="d-flex align-items-center mb-4">
          <h4 class="text-body-emphasis mb-0 me-2">Team members</h4>
          <?php if (user_has_permission('project','create|update|delete')): ?>
            <button class="btn btn-sm btn-outline-atlis" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal">+</button>
          <?php endif; ?>
        </div>
        <?php if (!empty($assignedUsers)): ?>
          <ul class="list-unstyled mb-4">
            <?php foreach ($assignedUsers as $au): ?>
              <li class="d-flex align-items-center mb-2">
                <div class="avatar avatar-xl me-2">
                  <img class="rounded-circle" src="<? echo getURLDir(); ?>module/users/uploads/<?= h($au['profile_pic'] ?? '') ?>" alt="<?= h($au['name']) ?>" />
                </div>
                <div class="d-flex align-items-center flex-grow-1">
                  <h6 class="mb-0"><?= h($au['name']) ?></h6>
                  <?php if (user_has_permission('project','create|update|delete')): ?>
                    <form method="post" action="functions/remove_user.php" class="ms-2" onclick="return confirm('Remove this user?')">
                      <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                      <input type="hidden" name="user_id" value="<?= (int)$au['user_id'] ?>">
                      <button class="btn btn-sm btn-outline-danger" type="submit">-</button>
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
      <div class="col-8">
        <div class="mt-6">
          <h2 class="mb-4">Todo list<span class="text-body-tertiary fw-normal">(<?= count($tasks) ?>)</span></h2>
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
          <div class="mb-4 todo-list">
            <?php if (!empty($tasks)): ?>
              <?php foreach ($tasks as $t): ?>
                <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-translucent py-3 gx-0 cursor-pointer border-top">
                  <div class="col-12 col-md-auto flex-1">
                    <div>
                      <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                        <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2" type="checkbox" <?= !empty($t['completed']) ? 'checked' : '' ?> />
                        <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1 flex-grow-1 flex-md-grow-0 cursor-pointer"><?= h($t['name']) ?></label><span class="badge badge-phoenix fs-10 badge-phoenix-<?= h($t['status_color']) ?>"><?= h($t['status_label']) ?></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-auto">
                    <div class="d-flex ms-4 lh-1 align-items-center">
                      <button class="btn btn-link p-0 text-body-tertiary fs-10 me-2"><span class="fas fa-paperclip me-1"></span><?= (int)($t['attachment_count'] ?? 0) ?></button>
                      <p class="text-body-tertiary fs-10 mb-md-0 me-2 me-md-3 mb-0"><?= !empty($t['due_date']) ? h(date('d M, Y', strtotime($t['due_date']))) : '' ?></p>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="fs-9 text-body-secondary mb-0">No tasks found.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
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
                    <div class="d-flex">
                      <p class="fs-9 lh-sm mb-1 flex-grow-1"><?= nl2br(h($n['note_text'])) ?></p>
                      <?php if ($is_admin || ($n['user_id'] ?? 0) == $this_user_id): ?>
                      <form action="functions/delete_note.php" method="post" class="ms-2" onsubmit="return confirm('Delete this note?');">
                        <input type="hidden" name="id" value="<?= (int)$n['id'] ?>">
                        <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                        <button class="btn btn-link p-0 text-danger" type="submit"><span class="fa-solid fa-trash"></span></button>
                      </form>
                      <?php endif; ?>
                    </div>
                    <p class="fs-9 mb-0">by <a class="fw-semibold" href="#!"><?= h($n['user_name'] ?? '') ?></a></p>
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
          <form action="functions/add_note.php" method="post">
            <input type="hidden" name="id" value="<?= (int)$current_project['id'] ?>">
            <div class="mb-3">
              <textarea class="form-control" name="note" rows="3" required></textarea>
            </div>
            <button class="btn btn-atlis" type="submit">Add Note</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
      <div class="px-4 px-lg-6">
        <h4 class="mb-3">Files</h4>
      </div>
      <?php if (user_has_permission('project','create|update|delete')): ?>
      <div class="border-top px-4 px-lg-6 py-4">
        <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
          <input type="hidden" name="id" value="<?= (int)$current_project['id'] ?>">
          <input class="form-control mb-2" type="file" name="file" required>
          <button class="btn btn-outline-atlis" type="submit">Upload</button>
        </form>
      </div>
      <?php endif; ?>
      <?php if (!empty($files)): ?>
        <?php foreach ($files as $f): ?>
        <div class="border-top px-4 px-lg-6 py-4">
          <div class="me-n3">
            <div class="d-flex flex-between-center">
              <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                <p class="text-body-highlight mb-0 lh-1">
                  <?php if (strpos($f['file_type'], 'image/') === 0): ?>
                    <a class="text-body-highlight" href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<? echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                  <?php else: ?>
                    <a class="text-body-highlight" href="<? echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a>
                  <?php endif; ?>
                </p>
              </div>
              <?php if ($is_admin || ($f['user_id'] ?? 0) == $this_user_id): ?>
              <form action="functions/delete_file.php" method="post" onsubmit="return confirm('Delete this file?');">
                <input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
                <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                <button class="btn btn-link p-0 text-danger" type="submit"><span class="fa-solid fa-trash"></span></button>
              </form>
              <?php endif; ?>
            </div>
            <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span></div>
            <?php if (strpos($f['file_type'], 'image/') === 0): ?>
              <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<? echo getURLDir(); ?><?= h($f['file_path']) ?>">
                <img class="rounded-2 mt-2" src="<? echo getURLDir(); ?><?= h($f['file_path']) ?>" alt="" style="width:320px" />
              </a>
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
          <button class="btn btn-atlis" type="submit">Assign</button>
        </div>
      </form>
    </div>
  </div>
  <?php endif; ?>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
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
  });
  </script>
  <?php else: ?>
  <p>No project found.</p>
  <?php endif; ?>
