<?php
$statusCounts = [];
foreach ($projects as $proj) {
  $label = $proj['status_label'] ?? 'Unknown';
  $statusCounts[$label] = ($statusCounts[$label] ?? 0) + 1;
}
?>
<nav class="mb-3" aria-label="breadcrumb">
  <ol class="breadcrumb mb-0">
    <li class="breadcrumb-item"><a href="#">Projects</a></li>
    <li class="breadcrumb-item active" aria-current="page">Card View</li>
  </ol>
</nav>
<div class="row gx-6 gy-3 mb-4 align-items-center">
  <div class="col-auto">
    <h2 class="mb-0">Projects<span class="fw-normal text-body-tertiary ms-3">(<?php echo count($projects); ?>)</span></h2>
  </div>
  <?php if (user_has_permission('project','create')): ?>
  <div class="col-auto">
    <a class="btn btn-success px-5" href="index.php?action=create"><i class="fa-solid fa-plus me-2"></i>Add new project</a>
  </div>
  <?php endif; ?>
</div>
<div class="row justify-content-between align-items-end mb-4 g-3">
  <div class="col-12 col-sm-auto">
    <ul class="nav nav-links mx-n2 project-tab">
      <li class="nav-item"><a class="nav-link px-2 py-1 active" aria-current="page" href="#"><span>All</span><span class="text-body-tertiary fw-semibold">(<?php echo count($projects); ?>)</span></a></li>
      <?php foreach (['Ongoing','Cancelled','Finished','Postponed'] as $tab): ?>
      <li class="nav-item"><a class="nav-link px-2 py-1" href="#"><span><?php echo $tab; ?></span><span class="text-body-tertiary fw-semibold">(<?php echo $statusCounts[$tab] ?? 0; ?>)</span></a></li>
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
    </div>
  </div>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-3 mb-9">
  <?php foreach ($projects as $project): ?>
  <div class="col">
    <div class="card h-100 hover-actions-trigger">
      <div class="card-body position-relative">
        <div class="d-flex align-items-center">
          <h4 class="mb-2 line-clamp-1 lh-sm flex-1 me-5">
            <a href="index.php?action=details&id=<?php echo $project['id']; ?>"><?php echo h($project['name']); ?></a>
          </h4>
          <div class="hover-actions top-0 end-0 mt-4 me-4">
            <a class="btn btn-primary btn-icon flex-shrink-0" href="index.php?action=details&id=<?php echo $project['id']; ?>"><span class="fa-solid fa-chevron-right"></span></a>
          </div>
        </div>
        <span class="badge badge-phoenix fs-10 mb-4 badge-phoenix-<?php echo h($project['status_color'] ?? 'secondary'); ?>"><?php echo h($project['status_label'] ?? ''); ?></span>
        <?php if (!empty($project['description'])): ?>
        <p class="text-body-secondary line-clamp-2 mb-4"><?php echo h($project['description']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['start_date'])): ?>
        <div class="d-flex align-items-center mt-4">
          <p class="mb-0 fw-bold fs-9">Started :<span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo h(date('F jS, Y', strtotime($project['start_date']))); ?></span></p>
        </div>
        <?php endif; ?>
        <?php if (!empty($project['complete_date'])): ?>
        <div class="d-flex align-items-center mt-2">
          <p class="mb-0 fw-bold fs-9">Deadline : <span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo h(date('F jS, Y', strtotime($project['complete_date']))); ?></span></p>
        </div>
        <?php endif; ?>
        <?php if (!empty($project['assignees'])): ?>
        <div class="avatar-group mt-3">
          <?php foreach ($project['assignees'] as $assignee): ?>
          <div class="avatar avatar-s rounded-circle">
            <img class="rounded-circle" src="<?php echo getURLDir(); ?>module/users/uploads/<?= h($assignee['profile_pic'] ?? ''); ?>" alt="<?= h($assignee['name'] ?? ''); ?>" />
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <a class="stretched-link" href="index.php?action=details&id=<?php echo $project['id']; ?>"></a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
