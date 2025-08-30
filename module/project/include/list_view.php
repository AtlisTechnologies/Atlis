<?php
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="#">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">List View</li>
  </ol>
</nav>
<div class="row">
  <div class="col-md-3 mb-3" id="filterSidebar">
    <div class="mb-3">
      <h6>Organization</h6>
      <?php foreach($organizations as $org): if(in_array($org['id'],$userOrgIds)): ?>
      <div class="form-check">
        <input class="form-check-input org-filter" type="checkbox" value="<?= h($org['name']); ?>" id="org-filter-<?= $org['id']; ?>" checked>
        <label class="form-check-label" for="org-filter-<?= $org['id']; ?>"><?= h($org['name']); ?></label>
      </div>
      <?php endif; endforeach; ?>
    </div>
    <div class="mb-3">
      <h6>Agency</h6>
      <?php foreach($agencies as $agency): if(in_array($agency['id'],$userAgencyIds)): ?>
      <div class="form-check">
        <input class="form-check-input agency-filter" type="checkbox" value="<?= h($agency['name']); ?>" data-org="<?= h($agency['organization_id']); ?>" id="agency-filter-<?= $agency['id']; ?>" checked>
        <label class="form-check-label" for="agency-filter-<?= $agency['id']; ?>"><?= h($agency['name']); ?></label>
      </div>
      <?php endif; endforeach; ?>
    </div>
    <div class="mb-3">
      <h6>Division</h6>
      <?php foreach($divisions as $division): if(in_array($division['id'],$userDivisionIds)): ?>
      <div class="form-check">
        <input class="form-check-input division-filter" type="checkbox" value="<?= h($division['name']); ?>" data-agency="<?= h($division['agency_id']); ?>" id="division-filter-<?= $division['id']; ?>" checked>
        <label class="form-check-label" for="division-filter-<?= $division['id']; ?>"><?= h($division['name']); ?></label>
      </div>
      <?php endif; endforeach; ?>
    </div>
    <div class="mb-3">
      <h6>Status</h6>
      <div class="form-check">
        <input class="form-check-input status-filter" type="checkbox" value="" id="status-all" checked>
        <label class="form-check-label" for="status-all">All Statuses</label>
      </div>
      <?php foreach ($statusItems as $status): ?>
      <div class="form-check">
        <input class="form-check-input status-filter" type="checkbox" value="<?= h($status['label']); ?>" id="status-filter-<?= $status['id']; ?>" checked>
        <label class="form-check-label" for="status-filter-<?= $status['id']; ?>"><?= h($status['label']); ?></label>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="mb-3">
      <h6>Priority</h6>
      <div class="form-check">
        <input class="form-check-input priority-filter" type="checkbox" value="" id="priority-all" checked>
        <label class="form-check-label" for="priority-all">All Priorities</label>
      </div>
      <?php foreach ($priorityItems as $priority): ?>
      <div class="form-check">
        <input class="form-check-input priority-filter" type="checkbox" value="<?= h($priority['label']); ?>" id="priority-filter-<?= $priority['id']; ?>" checked>
        <label class="form-check-label" for="priority-filter-<?= $priority['id']; ?>"><?= h($priority['label']); ?></label>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="col-md-9">
    <div id="projectSummary" data-list='{"valueNames":["project","assignees","start","deadline","projectprogress","status","priority","organization","agency","division","action"],"page":10,"pagination":true}'>
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
    <?php if (user_has_permission('project','create')): ?>
    <div class="col-auto">
      <a class="btn btn-success px-5" href="index.php?action=create"><i class="fa-solid fa-plus me-2"></i>Create Project</a>
    </div>
    <?php endif; ?>
  </div>
      <div class="table-responsive ms-n1 ps-1 scrollbar">
    <table class="table fs-9 mb-0 border-top border-translucent">
      <thead>
        <tr>
          <th scope="col" style="width:2%;"></th>
          <th class="sort white-space-nowrap align-middle ps-0" scope="col" data-sort="project" style="width:30%;">PROJECT NAME</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="assignees" style="width:10%;">Assignees</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="start" style="width:10%;">START DATE</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="deadline" style="width:15%;">DEADLINE</th>
          <th class="sort align-middle ps-3" scope="col" data-sort="projectprogress" style="width:5%;">PROGRESS</th>
          <th class="align-middle ps-8" scope="col" data-sort="status" style="width:10%;">STATUS</th>
          <th class="align-middle ps-3" scope="col" data-sort="priority" style="width:10%;">PRIORITY</th>
          <th class="sort align-middle text-end" scope="col" style="width:10%;"></th>
        </tr>
      </thead>
      <tbody class="list" id="pinnedProjects">
        <?php foreach ($projects as $project): ?>
          <?php if ($project['pinned']): ?>
        <tr class="position-static pinned-row bg-body-tertiary border-start border-atlis border-3" data-project-id="<?= (int)$project['id']; ?>">
          <td class="align-middle text-center">
            <?php if (user_has_permission('project','read')): ?>
            <button class="bg-transparent border-0 p-0 text-warning pin-toggle" data-project-id="<?= (int)$project['id']; ?>" aria-label="Pin project">
              <span class="fa-solid fa-thumbtack"></span>
            </button>
            <?php endif; ?>
          </td>
          <td class="align-middle time white-space-nowrap ps-0 project">
            <span class="svg-inline--fa fa-grip-vertical drag-handle me-2"></span>
            <a class="fw-bold fs-8" href="index.php?action=details&id=<?php echo $project['id']; ?>"><?php echo h($project['name']); ?></a>
            <span class="d-none priority"><?php echo h($project['priority_label'] ?? ''); ?></span>
            <span class="d-none organization"><?php echo h($project['organization_name'] ?? ''); ?></span>
            <span class="d-none agency"><?php echo h($project['agency_name'] ?? ''); ?></span>
            <span class="d-none division"><?php echo h($project['division_name'] ?? ''); ?></span>
          </td>
          <td class="align-middle white-space-nowrap assignees ps-3">
            <div class="avatar-group avatar-group-dense">
              <?php foreach ($project['assignees'] as $assignee): ?>
                <?php $pic = !empty($assignee['file_path']) ? $assignee['file_path'] : 'assets/img/team/avatar.webp'; ?>
                <div class="avatar avatar-s rounded-circle">
                  <img class="rounded-circle" src="<?php echo getURLDir() . h($pic); ?>" alt="<?= h($assignee['name']); ?>" />
                </div>
              <?php endforeach; ?>
            </div>
          </td>
          <td class="align-middle ps-3 start"><?php echo !empty($project['start_date']) ? h(date('F jS, Y', strtotime($project['start_date']))) : ''; ?></td>
          <td class="align-middle ps-3 deadline"><?php echo !empty($project['complete_date']) ? h(date('F jS, Y', strtotime($project['complete_date']))) : ''; ?></td>
          <td class="align-middle ps-3 projectprogress">
            <div class="d-flex align-items-center gap-2">
              <div class="progress flex-grow-1" style="height:4px;">
                <div class="progress-bar" style="width:<?= $project['total_tasks'] ? ($project['completed_tasks']/$project['total_tasks']*100) : 0; ?>%"></div>
              </div>
              <span class="fs-9"><?= h($project['completed_tasks']); ?>/<?= h($project['total_tasks']); ?></span>
            </div>
          </td>
          <td class="align-middle ps-8 status"><span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($project['status_color']); ?>"><?php echo h($project['status_label']); ?></span></td>
          <td class="align-middle ps-3 priority">
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($project['priority_color']); ?>">
              <?php echo h($project['priority_label']); ?>
            </span>
          </td>
          <td class="align-middle text-end">
            <div class="btn-reveal-trigger position-static d-flex justify-content-end align-items-center gap-2">
              <button class="btn btn-link p-0 pin-toggle ms-4" data-project-id="<?php echo (int)$project['id']; ?>" title="Toggle pin">
                <span class="fa-solid fa-thumbtack text-warning"></span>
              </button>
              <a class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" href="index.php?action=details&id=<?php echo $project['id']; ?>"><span class="fas fa-chevron-right fs-10"></span></a>
            </div>
          </td>
        </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
      <tbody class="list" id="regularProjects">
        <?php foreach ($projects as $project): ?>
          <?php if (!$project['pinned']): ?>
        <tr class="position-static" data-project-id="<?= (int)$project['id']; ?>">
          <td class="align-middle text-center">
            <?php if (user_has_permission('project','read')): ?>
            <button class="bg-transparent border-0 p-0 text-warning pin-toggle" data-project-id="<?= (int)$project['id']; ?>" aria-label="Pin project">
              <span class="fa-solid fa-thumbtack fa-rotate-90"></span>
            </button>
            <?php endif; ?>
          </td>
          <td class="align-middle time white-space-nowrap ps-0 project">
            <span class="svg-inline--fa fa-grip-vertical drag-handle me-2"></span>
            <a class="fw-bold fs-8" href="index.php?action=details&id=<?php echo $project['id']; ?>"><?php echo h($project['name']); ?></a>
            <span class="d-none priority"><?php echo h($project['priority_label'] ?? ''); ?></span>
            <span class="d-none organization"><?php echo h($project['organization_name'] ?? ''); ?></span>
            <span class="d-none agency"><?php echo h($project['agency_name'] ?? ''); ?></span>
            <span class="d-none division"><?php echo h($project['division_name'] ?? ''); ?></span>
          </td>
          <td class="align-middle white-space-nowrap assignees ps-3">
            <div class="avatar-group avatar-group-dense">
              <?php foreach ($project['assignees'] as $assignee): ?>
                <?php $pic = !empty($assignee['file_path']) ? $assignee['file_path'] : 'assets/img/team/avatar.webp'; ?>
                <div class="avatar avatar-s rounded-circle">
                  <img class="rounded-circle" src="<?php echo getURLDir() . h($pic); ?>" alt="<?= h($assignee['name']); ?>" />
                </div>
              <?php endforeach; ?>
            </div>
          </td>
          <td class="align-middle ps-3 start"><?php echo !empty($project['start_date']) ? h(date('F jS, Y', strtotime($project['start_date']))) : ''; ?></td>
          <td class="align-middle ps-3 deadline"><?php echo !empty($project['complete_date']) ? h(date('F jS, Y', strtotime($project['complete_date']))) : ''; ?></td>
          <td class="align-middle ps-3 projectprogress">
            <div class="d-flex align-items-center gap-2">
              <div class="progress flex-grow-1" style="height:4px;">
                <div class="progress-bar" style="width:<?= $project['total_tasks'] ? ($project['completed_tasks']/$project['total_tasks']*100) : 0; ?>%"></div>
              </div>
              <span class="fs-9"><?= h($project['completed_tasks']); ?>/<?= h($project['total_tasks']); ?></span>
            </div>
          </td>
          <td class="align-middle ps-8 status"><span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($project['status_color']); ?>"><?php echo h($project['status_label']); ?></span></td>
          <td class="align-middle ps-3 priority">
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo h($project['priority_color']); ?>">
              <?php echo h($project['priority_label']); ?>
            </span>
          </td>
          <td class="align-middle text-end">
            <div class="btn-reveal-trigger position-static d-flex justify-content-end align-items-center gap-2">
              <button class="btn btn-link p-0 pin-toggle" data-project-id="<?php echo (int)$project['id']; ?>" title="Toggle pin">
                <span class="fa-solid fa-thumbtack text-body-tertiary"></span>
              </button>
              <a class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs-10" href="index.php?action=details&id=<?php echo $project['id']; ?>"><span class="fas fa-chevron-right fs-10"></span></a>
            </div>
          </td>
        </tr>
          <?php endif; ?>
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
  </div>
</div>
<script>
  const csrfToken = '<?= csrf_token(); ?>';
  function setupProjectList() {
    const projectSummaryEl = document.getElementById('projectSummary');
    const options = window.phoenix.utils.getData(projectSummaryEl, 'list');
    const projectList = new List(projectSummaryEl, options);
    window.projectList = projectList;

    function applyFilters() {
      const statusAll = document.getElementById('status-all').checked;
      const priorityAll = document.getElementById('priority-all').checked;
      const statusVals = statusAll ? [] : Array.from(document.querySelectorAll('.status-filter:checked')).map(cb => cb.value).filter(Boolean);
      const priorityVals = priorityAll ? [] : Array.from(document.querySelectorAll('.priority-filter:checked')).map(cb => cb.value).filter(Boolean);
      const orgVals = Array.from(document.querySelectorAll('.org-filter:checked')).map(cb => cb.value);
      const agencyVals = Array.from(document.querySelectorAll('.agency-filter:checked')).map(cb => cb.value);
      const divisionVals = Array.from(document.querySelectorAll('.division-filter:checked')).map(cb => cb.value);
      projectList.filter(item => {
        const v = item.values();
        const statusMatch = !statusVals.length || statusVals.includes(v.status);
        const priorityMatch = !priorityVals.length || priorityVals.includes(v.priority);
        const orgMatch = !orgVals.length || orgVals.includes(v.organization);
        const agencyMatch = !agencyVals.length || agencyVals.includes(v.agency);
        const divisionMatch = !divisionVals.length || divisionVals.includes(v.division);
        return statusMatch && priorityMatch && orgMatch && agencyMatch && divisionMatch;
      });
    }

    document.querySelectorAll('.status-filter, .priority-filter, .org-filter, .agency-filter, .division-filter').forEach(cb => cb.addEventListener('change', applyFilters));
    applyFilters();

    const pinnedBody = document.getElementById('pinnedProjects');
    const regularBody = document.getElementById('regularProjects');

    function sendOrder(type){
      const ids=[...document.querySelectorAll(`#${type}Projects tr`)].map((tr,i)=>`${type}[]=${tr.dataset.projectId}`);
      fetch('functions/update_sort.php',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:ids.join('&')});
    }

    document.querySelectorAll('.pin-toggle').forEach(btn => {
      btn.addEventListener('click', async e => {
        e.preventDefault();
        const projectId = btn.dataset.projectId;
        const row = btn.closest('tr');
        if (!projectId || !row) return;
        try {
          const res = await fetch('functions/toggle_pin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ project_id: projectId, csrf_token: csrfToken })
          });
          const data = await res.json();
          const pinned = !!data.pinned;
          row.querySelectorAll('.pin-toggle span.fa-thumbtack').forEach(icon => {
            icon.classList.toggle('fa-rotate-90', !pinned);
            icon.classList.toggle('text-warning', pinned);
            icon.classList.toggle('text-body-tertiary', !pinned);
          });
          ['pinned-row', 'bg-body-tertiary', 'border-start', 'border-atlis', 'border-3'].forEach(cls => row.classList.toggle(cls, pinned));
          if (pinned) {
            pinnedBody.appendChild(row);
          } else {
            regularBody.appendChild(row);
          }
          projectList.reindex();
          sendOrder('pinned');
          sendOrder('unpinned');
        } catch (err) {
          console.error(err);
        }
      });
    });

    new Sortable(pinnedBody, {
      handle: '.drag-handle', animation: 150, group: { name:'pinned', pull:false, put:false },
      onEnd: () => { sendOrder('pinned'); projectList.reindex(); }
    });
    new Sortable(regularBody, {
      handle: '.drag-handle', animation: 150, group: { name:'regular', pull:false, put:false },
      onEnd: () => { sendOrder('unpinned'); projectList.reindex(); }
    });

    const viewAll = projectSummaryEl.querySelector('[data-list-view="*"]');
    const viewLess = projectSummaryEl.querySelector('[data-list-view="less"]');
    if(viewAll && viewLess){
      viewAll.addEventListener('click', e => {
        e.preventDefault();
        projectList.show(projectList.size());
        viewAll.classList.add('d-none');
        viewLess.classList.remove('d-none');
      });
      viewLess.addEventListener('click', e => {
        e.preventDefault();
        projectList.show(options.page);
        viewLess.classList.add('d-none');
        viewAll.classList.remove('d-none');
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupProjectList);
  } else {
    setupProjectList();
  }
</script>
