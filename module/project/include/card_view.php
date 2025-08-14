<?php
// Card view of projects

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
    <a class="btn btn-primary px-5" href="index.php?action=create"><i class="fa-solid fa-plus me-2"></i>Add new project</a>
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
      <a class="btn btn-phoenix-primary px-3 me-1" href="index.php?action=list" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="List view"><span class="fa-solid fa-list fs-10"></span></a>
      <a class="btn btn-phoenix-primary px-3 me-1" href="index.php?action=board" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Board view">
        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0.5C0 0.223857 0.223858 0 0.5 0H1.83333C2.10948 0 2.33333 0.223858 2.33333 0.5V1.83333C2.33333 2.10948 2.10948 2.33333 1.83333 2.33333H0.5C0.223857 2.33333 0 2.10948 0 1.83333V0.5Z" fill="currentColor"></path>
          <path d="M3.33333 0.5C3.33333 0.223857 3.55719 0 3.83333 0H5.16667C5.44281 0 5.66667 0.223858 5.66667 0.5V1.83333C5.66667 2.10948 5.44281 2.33333 5.16667 2.33333H3.83333C3.55719 2.33333 3.33333 2.10948 3.33333 1.83333V0.5Z" fill="currentColor"></path>
          <path d="M6.66667 0.5C6.66667 0.223857 6.89052 0 7.16667 0H8.5C8.77614 0 9 0.223858 9 0.5V1.83333C9 2.10948 8.77614 2.33333 8.5 2.33333H7.16667C6.89052 2.33333 6.66667 2.10948 6.66667 1.83333V0.5Z" fill="currentColor"></path>
          <path d="M0 3.83333C0 3.55719 0.223858 3.33333 0.5 3.33333H1.83333C2.10948 3.33333 2.33333 3.55719 2.33333 3.83333V5.16667C2.33333 5.44281 2.10948 5.66667 1.83333 5.66667H0.5C0.223857 5.66667 0 5.44281 0 5.16667V3.83333Z" fill="currentColor"></path>
          <path d="M3.33333 3.83333C3.33333 3.55719 3.55719 3.33333 3.83333 3.33333H5.16667C5.44281 3.33333 5.66667 3.55719 5.66667 3.83333V5.16667C5.66667 5.44281 5.44281 5.66667 5.16667 5.66667H3.83333C3.55719 5.66667 3.33333 5.44281 3.33333 5.16667V3.83333Z" fill="currentColor"></path>
          <path d="M6.66667 3.83333C6.66667 3.55719 6.89052 3.33333 7.16667 3.33333H8.5C8.77614 3.33333 9 3.55719 9 3.83333V5.16667C9 5.44281 8.77614 5.66667 8.5 5.66667H7.16667C6.89052 5.66667 6.66667 5.44281 6.66667 5.16667V3.83333Z" fill="currentColor"></path>
          <path d="M0 7.16667C0 6.89052 0.223858 6.66667 0.5 6.66667H1.83333C2.10948 6.66667 2.33333 6.89052 2.33333 7.16667V8.5C2.33333 8.77614 2.10948 9 1.83333 9H0.5C0.223857 9 0 8.77614 0 8.5V7.16667Z" fill="currentColor"></path>
          <path d="M3.33333 7.16667C3.33333 6.89052 3.55719 6.66667 3.83333 6.66667H5.16667C5.44281 6.66667 5.66667 6.89052 5.66667 7.16667V8.5C5.66667 8.77614 5.44281 9 5.16667 9H3.83333C3.55719 9 3.33333 8.77614 3.33333 8.5V7.16667Z" fill="currentColor"></path>
          <path d="M6.66667 7.16667C6.66667 6.89052 6.89052 6.66667 7.16667 6.66667H8.5C8.77614 6.66667 9 6.89052 9 7.16667V8.5C9 8.77614 8.77614 9 8.5 9H7.16667C6.89052 9 6.66667 8.77614 6.66667 8.5V7.16667Z" fill="currentColor"></path>
        </svg>
      </a>
      <a class="btn btn-phoenix-primary px-3 border-0 text-body" href="index.php?action=card" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Card view">
        <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 0.5C0 0.223858 0.223858 0 0.5 0H3.5C3.77614 0 4 0.223858 4 0.5V3.5C4 3.77614 3.77614 4 3.5 4H0.5C0.223858 4 0 3.77614 0 3.5V0.5Z" fill="currentColor"></path>
          <path d="M0 5.5C0 5.22386 0.223858 5 0.5 5H3.5C3.77614 5 4 5.22386 4 5.5V8.5C4 8.77614 3.77614 9 3.5 9H0.5C0.223858 9 0 8.77614 0 8.5V5.5Z" fill="currentColor"></path>
          <path d="M5 0.5C5 0.223858 5.22386 0 5.5 0H8.5C8.77614 0 9 0.223858 9 0.5V3.5C9 3.77614 8.77614 4 8.5 4H5.5C5.22386 4 5 3.77614 5 3.5V0.5Z" fill="currentColor"></path>
          <path d="M5 5.5C5 5.22386 5.22386 5 5.5 5H8.5C8.77614 5 9 5.22386 9 5.5V8.5C9 8.77614 8.77614 9 8.5 9H5.5C5.22386 9 5 8.77614 5 8.5V5.5Z" fill="currentColor"></path>
        </svg>
      </a>
    </div>
  </div>
</div>
<div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 row-cols-xxl-4 g-3 mb-9">
  <?php foreach ($projects as $project): ?>
  <div class="col">
    <div class="card h-100 hover-actions-trigger">
      <div class="card-body">
        <div class="d-flex align-items-center">
          <h4 class="mb-2 line-clamp-1 lh-sm flex-1 me-5">
            <a href="index.php?action=details&id=<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['name']); ?></a>
          </h4>
          <div class="hover-actions top-0 end-0 mt-4 me-4">
            <a class="btn btn-primary btn-icon flex-shrink-0" href="index.php?action=details&id=<?php echo $project['id']; ?>"><span class="fa-solid fa-chevron-right"></span></a>
          </div>
        </div>
        <span class="badge badge-phoenix fs-10 mb-4 badge-phoenix-<?php echo htmlspecialchars($project['status_color']); ?>"><?php echo htmlspecialchars($project['status_label']); ?></span>
        <?php if (!empty($project['description'])): ?>
        <p class="text-body-secondary line-clamp-2 mb-4"><?php echo htmlspecialchars($project['description']); ?></p>
        <?php endif; ?>
        <?php if (!empty($project['start_date'])): ?>
        <div class="d-flex align-items-center mt-4">
          <p class="mb-0 fw-bold fs-9">Started :<span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo htmlspecialchars($project['start_date']); ?></span></p>
        </div>
        <?php endif; ?>
        <?php if (!empty($project['complete_date'])): ?>
        <div class="d-flex align-items-center mt-2">
          <p class="mb-0 fw-bold fs-9">Deadline : <span class="fw-semibold text-body-tertiary text-opactity-85 ms-1"><?php echo htmlspecialchars($project['complete_date']); ?></span></p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>

