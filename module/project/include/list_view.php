<?php
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="#">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">List View</li>
  </ol>
</nav>
<div id="projectSummary" data-list='{"valueNames":["project","assignees","start","deadline","projectprogress","status","action"],"page":6,"pagination":true}'>
  <div class="row align-items-end justify-content-between pb-4 g-3">
    <div class="col-auto">
      <h3>Projects</h3>
      <p class="text-body-tertiary lh-sm mb-0">Brief summary of all projects</p>
    </div>
    <div class="col-12 col-md-auto">
      <div class="search-box">
        <form class="position-relative" data-bs-toggle="search">
          <input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
  </div>
  <div class="table-responsive ms-n1 ps-1 scrollbar">
    <table class="table fs-9 mb-0 border-top border-translucent">
      <thead>
        <tr>
          <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="project" style="width:30%;">PROJECT NAME</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="assignees" style="width:10%;">Assignees</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
          <th class="align-middle ps-8" scope="col" data-sort="status" style="width:10%;">STATUS</th>
          <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
        </tr>
      </thead>
      <tbody class="list" id="project-summary-table-body">
        <?php foreach ($projects as $project): ?>
        <tr class="position-static">
          <td class="align-middle time white-space-nowrap ps-0 project"><a class="fw-bold fs-8" href="index.php?action=details&id=<?php echo $project['id']; ?>"><?php echo h($project['name']); ?></a></td>
          <td class="align-middle white-space-nowrap assignees ps-3">
            <div class="avatar-group avatar-group-dense">
              <?php foreach ($project['assignees'] as $assignee): ?>
                <?php $pic = !empty($assignee['profile_pic']) ? '../users/uploads/' . $assignee['profile_pic'] : '../../assets/img/team/avatar.webp'; ?>
                <div class="avatar avatar-s rounded-circle">
                  <img class="rounded-circle" src="<? echo getURLDir(); ?><?= h($pic); ?>" alt="<?= h($assignee['name']); ?>" />
                </div>
              <?php endforeach; ?>
            </div>
          </td>
          <td class="align-middle ps-3 start"><?php echo !empty($project['start_date']) ? h(date('F jS, Y', strtotime($project['start_date']))) : ''; ?></td>
          <td class="align-middle ps-3 deadline"><?php echo !empty($project['complete_date']) ? h(date('F jS, Y', strtotime($project['complete_date']))) : ''; ?></td>
          <td class="align-middle ps-3 projectprogress"><?php echo h($project['completed_tasks']) . '/' . h($project['total_tasks']); ?></td>
          <td class="align-middle ps-8 status"><span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($project['status_color']); ?>"><?php echo h($project['status_label']); ?></span></td>
          <td class="align-middle text-end">
            <div class="btn-reveal-trigger position-static">
              <a class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" href="index.php?action=details&id=<?php echo $project['id']; ?>"><span class="fas fa-chevron-right fs-10"></span></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
    <div class="col-auto d-flex">
      <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
    </div>
    <div class="col-auto d-flex">
      <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
      <ul class="mb-0 pagination"></ul>
      <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
    </div>
  </div>
</div>
