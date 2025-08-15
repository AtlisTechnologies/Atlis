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
        <div class="col-12 col-lg-8 col-xl-5">
          <div class="d-flex align-items-center mb-4">
            <h4 class="text-body-emphasis mb-0 me-2">Team members</h4>
            <button class="btn btn-sm btn-outline-atlis" type="button" data-bs-toggle="modal" data-bs-target="#assignUserModal">+</button>
          </div>
          <?php if (!empty($assignedUsers)): ?>
            <ul class="list-unstyled mb-4">
              <?php foreach ($assignedUsers as $au): ?>
                <li class="d-flex align-items-center mb-2">
                  <div class="avatar avatar-xl me-2">
                    <img class="rounded-circle" src="<?php echo getURLDir(); ?>module/users/uploads/<?= h($au['profile_pic'] ?? '') ?>" alt="<?= h($au['name']) ?>" />
                  </div>
                  <div class="flex-grow-1">
                    <h6 class="mb-0"><?= h($au['name']) ?></h6>
                  </div>
                  <form method="post" action="functions/remove_user.php" class="ms-2" onclick="return confirm('Remove this user?')">
                    <input type="hidden" name="project_id" value="<?= (int)$current_project['id'] ?>">
                    <input type="hidden" name="user_id" value="<?= (int)$au['user_id'] ?>">
                    <button class="btn btn-link p-0 text-decoration-none text-danger" type="submit"><span class="fa-solid fa-minus"></span></button>
                  </form>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="fs-9 text-body-secondary mb-4">No team members assigned.</p>
          <?php endif; ?>

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
                    <p class="fs-9 lh-sm mb-1"><?= nl2br(h($n['note_text'])) ?></p>
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
        <div class="mt-4">
          <form action="functions/add_note.php" method="post">
            <input type="hidden" name="id" value="<?= (int)$current_project['id'] ?>">
            <div class="mb-3">
              <textarea class="form-control" name="note" rows="3" required></textarea>
            </div>
            <button class="btn btn-atlis" type="submit">Add Note</button>
          </form>
        </div>
      </div>
      <div class="px-4 px-lg-6">
        <h4 class="mb-3">Files</h4>
      </div>
      <div class="border-top px-4 px-lg-6 py-4">
        <form action="functions/upload_file.php" method="post" enctype="multipart/form-data" class="mb-3">
          <input type="hidden" name="id" value="<?= (int)$current_project['id'] ?>">
          <input class="form-control mb-2" type="file" name="file" required>
          <button class="btn btn-outline-atlis" type="submit">Upload</button>
        </form>
      </div>
      <?php if (!empty($files)): ?>
        <?php foreach ($files as $f): ?>
        <div class="border-top px-4 px-lg-6 py-4">
          <div class="me-n3">
            <div class="d-flex flex-between-center">
              <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                <p class="text-body-highlight mb-0 lh-1"><a class="text-body-highlight" href="<? echo getURLDir(); ?><?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a></p>
              </div>
            </div>
            <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span></div>
            <?php if (strpos($f['file_type'], 'image/') === 0): ?>
              <img class="rounded-2 mt-2" src="<? echo getURLDir(); ?><?= h($f['file_path']) ?>" alt="" style="width:320px" />
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
});
</script>
<?php else: ?>
<p>No project found.</p>
<?php endif; ?>
