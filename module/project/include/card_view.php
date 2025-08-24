<?php
$projects = array_filter($projects, function($proj) use ($is_admin, $this_user_id) {
    if (!empty($proj['is_private']) && !($is_admin || ($proj['user_id'] ?? 0) == $this_user_id)) {
        return false;
    }
    return true;
});
$statusCounts = [];
foreach ($projects as $proj) {
    $label = $proj['status_label'] ?? 'Unknown';
    $statusCounts[$label] = ($statusCounts[$label] ?? 0) + 1;
}
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="index.php">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Card View</li>
  </ol>
</nav>
<div class="row gx-6 gy-3 mb-4 align-items-center">
  <div class="col-auto">
    <h2 class="mb-0">Projects<span class="fw-normal text-body-tertiary ms-3">(<?php echo count($projects); ?>)</span></h2>
  </div>
  <?php if (user_has_permission('project','create')): ?>
  <div class="col-auto"><a class="btn btn-success px-5" href="index.php?action=create"><i class="fa-solid fa-plus me-2"></i>Add new project</a></div>
  <?php endif; ?>
</div>
<div class="row justify-content-between align-items-end mb-4 g-3">
  <div class="col-12 col-sm-auto">
    <ul class="nav nav-links mx-n2 project-tab">
      <li class="nav-item"><a class="nav-link px-2 py-1 active" aria-current="page" href="#"><span>All</span><span class="text-body-tertiary fw-semibold">(<?php echo count($projects); ?>)</span></a></li>
      <?php foreach (['Ongoing','Cancelled','Finished','Postponed'] as $tab): ?>
        <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span><?php echo $tab; ?></span><span class="text-body-tertiary fw-semibold"><?php echo $statusCounts[$tab] ?? 0; ?></span></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="col-12 col-sm-auto">
    <div class="d-flex align-items-center">
      <div class="search-box me-3">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search projects" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
      <a class="btn btn-phoenix-primary px-3 me-1" href="index.php?action=list" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view"><span class="fa-solid fa-list fs-10"></span></a>
      <a class="btn btn-phoenix-primary px-3 border-0 text-body" href="index.php?action=card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Card view">
        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0.5C0 0.223858 0.223858 0 0.5 0H3.5C3.77614 0 4 0.223858 4 0.5V3.5C4 3.77614 3.77614 4 3.5 4H0.5C0.223858 4 0 3.77614 0 3.5V0.5Z" fill="currentColor"/>
          <path d="M0 5.5C0 5.22386 0.223858 5 0.5 5H3.5C3.77614 5 4 5.22386 4 5.5V8.5C4 8.77614 3.77614 9 3.5 9H0.5C0.223858 9 0 8.77614 0 8.5V5.5Z" fill="currentColor"/>
          <path d="M5 0.5C5 0.223858 5.22386 0 5.5 0H8.5C8.77614 0 9 0.223858 9 0.5V3.5C9 3.77614 8.77614 4 8.5 4H5.5C5.22386 4 5 3.77614 5 3.5V0.5Z" fill="currentColor"/>
          <path d="M5 5.5C5 5.22386 5.22386 5 5.5 5H8.5C8.77614 5 9 5.22386 9 5.5V8.5C9 8.77614 8.77614 9 8.5 9H5.5C5.22386 9 5 8.77614 5 8.5V5.5Z" fill="currentColor"/>
        </svg>
      </a>
    </div>
  </div>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-3 mb-9">
  <?php foreach ($projects as $project):
    $completed = ($project['total_tasks'] ?? 0) - ($project['in_progress'] ?? 0);
    $progress = ($project['total_tasks'] ?? 0) > 0 ? intval(($completed / $project['total_tasks']) * 100) : 0;
  ?>
  <div class="col">
    <div class="card h-100 hover-actions-trigger">
      <div class="card-body position-relative">
        <div class="d-flex align-items-center">
          <button class="btn btn-link p-0 me-2 pin-toggle" data-project-id="<?php echo (int)$project['id']; ?>" title="Toggle pin">
            <span class="fa-solid fa-thumbtack <?php echo $project['pinned'] ? 'text-warning' : 'text-body-tertiary'; ?>"></span>
          </button>
          <h4 class="mb-2 line-clamp-1 lh-sm flex-1 me-5"><a href="index.php?action=details&id=<?php echo (int)$project['id']; ?>"><?php echo h($project['name']); ?></a></h4>
          <div class="hover-actions top-0 end-0 mt-4 me-4"><a class="btn btn-primary btn-icon flex-shrink-0" href="index.php?action=details&id=<?php echo (int)$project['id']; ?>"><span class="fa-solid fa-chevron-right"></span></a></div>
        </div>
        <span class="badge badge-phoenix fs-10 mb-4 badge-phoenix-<?php echo h($project['status_color'] ?? 'secondary'); ?>"><?php echo h($project['status_label'] ?? ''); ?></span>
        <?php if (!empty($project['agency_name']) || !empty($project['division_name'])): ?>
        <p class="text-body-secondary line-clamp-2 mb-4"><?php echo h($project['agency_name']); ?><?php if (!empty($project['division_name'])) echo ' / ' . h($project['division_name']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['start_date'])): ?>
        <div class="d-flex align-items-center mt-4"><p class="mb-0 fw-bold fs-9">Started :<span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo h(date('F jS, Y', strtotime($project['start_date']))); ?></span></p></div>
        <?php endif; ?>
        <?php if (!empty($project['complete_date'])): ?>
        <div class="d-flex align-items-center mt-2"><p class="mb-0 fw-bold fs-9">Deadline : <span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo h(date('F jS, Y', strtotime($project['complete_date']))); ?></span></p></div>
        <?php endif; ?>
        <div class="d-flex justify-content-between text-body-tertiary fw-semibold mt-3">
          <p class="mb-2">Progress</p>
          <p class="mb-2 text-body-emphasis"><?php echo (int)($project['in_progress'] ?? 0); ?>/<?php echo (int)($project['total_tasks'] ?? 0); ?></p>
        </div>
        <div class="progress bg-success-subtle">
          <div class="progress-bar rounded bg-success" role="progressbar" style="width: <?php echo $progress; ?>%" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <?php if (!empty($project['assignees'])): ?>
        <div class="avatar-group mt-3">
          <?php foreach ($project['assignees'] as $assignee):
            $pic = !empty($assignee['file_path']) ? $assignee['file_path'] : 'assets/img/team/avatar.webp';
          ?>
          <div class="avatar avatar-m rounded-circle">
            <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-src="<?php echo getURLDir() . h($pic); ?>">
              <img class="rounded-circle" src="<?php echo getURLDir() . h($pic); ?>" alt="<?= h($assignee['name']); ?>" />
            </a>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <a class="stretched-link" href="index.php?action=details&id=<?php echo (int)$project['id']; ?>"></a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body p-0"><img src="" alt="" id="modalImage" class="w-100 rounded" /></div>
    </div>
  </div>
</div>
<script>
document.addEventListener('click', function (e) {
  var src = e.target.getAttribute('data-img-src');
  if (src) {
    var img = document.getElementById('modalImage');
    if (img) { img.src = src; }
  }
});

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.pin-toggle').forEach(btn => {
    btn.addEventListener('click', async e => {
      e.preventDefault();
      const projectId = btn.dataset.projectId;
      const icon = btn.querySelector('span');
      if (!projectId || !icon) return;
      try {
        const res = await fetch('functions/toggle_pin.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({ project_id: projectId })
        });
        const data = await res.json();
        if (data.pinned) {
          icon.classList.add('text-warning');
          icon.classList.remove('text-body-tertiary');
        } else {
          icon.classList.add('text-body-tertiary');
          icon.classList.remove('text-warning');
        }
      } catch (err) {
        console.error(err);
      }
    });
  });
});
</script>

