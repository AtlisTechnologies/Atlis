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
        <div class="col-12 col-sm-5 col-lg-4 col-xl-3 col-xxl-4">
          <div class="mb-5">
            <h4 class="text-body-emphasis">Work loads</h4>
            <h6 class="text-body-tertiary">Last 7 days</h6>
          </div>
          <div class="echart-top-coupons mb-5" style="height:115px;width:100%;"></div>
          <div class="row justify-content-center">
            <div class="col-auto col-sm-12">
              <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                <div class="col">
                  <div class="d-flex align-items-center">
                    <div class="bullet-item me-2 bg-primary"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Shantinan Mekalan</h6>
                  </div>
                </div>
                <div class="col-auto">
                  <h6 class="text-body fw-semibold mb-0">72%</h6>
                </div>
              </div>
              <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                <div class="col">
                  <div class="d-flex align-items-center">
                    <div class="bullet-item me-2 bg-primary-lighter"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Makena Zikonn</h6>
                  </div>
                </div>
                <div class="col-auto">
                  <h6 class="text-body fw-semibold mb-0">18%</h6>
                </div>
              </div>
              <div class="row justify-content-center justify-content-sm-between g-5 g-sm-0 mb-2">
                <div class="col">
                  <div class="d-flex align-items-center">
                    <div class="bullet-item me-2 bg-info"></div>
                    <h6 class="text-body fw-semibold flex-1 mb-0">Meena Kumari</h6>
                  </div>
                </div>
                <div class="col-auto">
                  <h6 class="text-body fw-semibold mb-0">10%</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-7 col-lg-8 col-xl-5">
          <h4 class="text-body-emphasis mb-4">Team members</h4>
          <div class="d-flex mb-8">
            <div class="dropdown"><a class="dropdown-toggle dropdown-caret-none d-inline-block outline-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                <div class="avatar avatar-xl  me-1">
                  <img class="rounded-circle " src="../../assets/img//team/33.webp" alt="" />
                </div>
              </a>
              <div class="dropdown-menu avatar-dropdown-menu p-0 overflow-hidden" style="width: 320px;">
                <div class="position-relative">
                  <div class="bg-holder z-n1" style="background-image:url(../../assets/img/bg/bg-32.png);background-size: auto;">
                  </div>
                  <div class="p-3">
                    <div class="text-end">
                      <button class="btn p-0 me-2"><span class="fa-solid fa-user-plus text-white"></span></button>
                      <button class="btn p-0"><span class="fa-solid fa-ellipsis text-white"></span></button>
                    </div>
                    <div class="text-center">
                      <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2 mb-2"><img class="rounded-circle border border-light-subtle" src="../../assets/img//team/33.webp" alt="" /></div>
                      <h6 class="text-white">Tyrion Lannister</h6>
                      <p class="text-light text-opacity-50 fw-semibold fs-10 mb-2">@tyrion222</p>
                      <div class="d-flex flex-center mb-3">
                        <h6 class="text-white mb-0">224 <span class="fw-normal text-light text-opacity-75">connections</span></h6><span class="fa-solid fa-circle text-body-tertiary mx-1" data-fa-transform="shrink-10 up-2"></span>
                        <h6 class="text-white mb-0">23 <span class="fw-normal text-light text-opacity-75">mutual</span></h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="bg-body-emphasis">
                  <div class="p-3 border-bottom border-translucent">
                    <div class="d-flex justify-content-between">
                      <div class="d-flex">
                        <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-phone"></span></button>
                        <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg me-2"><span class="fa-solid fa-message"></span></button>
                        <button class="btn btn-phoenix-secondary btn-icon btn-icon-lg"><span class="fa-solid fa-video"></span></button>
                      </div>
                      <button class="btn btn-phoenix-primary"><span class="fa-solid fa-envelope me-2"></span>Send Email</button>
                    </div>
                  </div>
                  <ul class="nav d-flex flex-column py-3 border-bottom">
                    <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body d-inline-block" data-feather="clipboard"></span><span class="text-body-highlight flex-1">Assigned Projects</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                    <li class="nav-item"><a class="nav-link px-3 d-flex flex-between-center" href="#!"> <span class="me-2 text-body" data-feather="pie-chart"></span><span class="text-body-highlight flex-1">View activiy</span><span class="fa-solid fa-chevron-right fs-11"></span></a></li>
                  </ul>
                </div>
                <div class="p-3 d-flex justify-content-between"><a class="btn btn-link p-0 text-decoration-none" href="#!">Details </a><a class="btn btn-link p-0 text-decoration-none text-danger" href="#!">Unassign </a></div>
              </div>
            </div>
          </div>
          <h4 class="text-body-emphasis mb-4">Tags</h4><span class="badge badge-tag me-2 mb-1">Unused_brain</span><span class="badge badge-tag me-2 mb-1">Machine</span><span class="badge badge-tag me-2 mb-1">Coding</span>
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
            <button class="btn btn-primary" type="submit">Add Note</button>
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
          <button class="btn btn-primary" type="submit">Upload</button>
        </form>
      </div>
      <?php if (!empty($files)): ?>
        <?php foreach ($files as $f): ?>
        <div class="border-top px-4 px-lg-6 py-4">
          <div class="me-n3">
            <div class="d-flex flex-between-center">
              <div class="d-flex mb-1"><span class="fa-solid <?= strpos($f['file_type'], 'image/') === 0 ? 'fa-image' : 'fa-file' ?> me-2 text-body-tertiary fs-9"></span>
                <p class="text-body-highlight mb-0 lh-1"><a class="text-body-highlight" href="<?= h($f['file_path']) ?>"><?= h($f['file_name']) ?></a></p>
              </div>
            </div>
            <div class="d-flex fs-9 text-body-tertiary mb-0 flex-wrap"><span><?= h($f['file_size']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['file_type']) ?></span><span class="text-body-quaternary mx-1">| </span><span class="text-nowrap"><?= h($f['date_created']) ?></span></div>
            <?php if (strpos($f['file_type'], 'image/') === 0): ?>
              <img class="rounded-2 mt-2" src="<?= h($f['file_path']) ?>" alt="" style="width:320px" />
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
<script src="/vendors/echarts/echarts.min.js"></script>
<script src="/assets/js/echarts-example.js"></script>
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
