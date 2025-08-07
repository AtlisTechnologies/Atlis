<nav class="navbar navbar-top fixed-top navbar-expand-lg" id="navbarAdmin" data-navbar-top="combo">
  <div class="navbar-logo">
    <button class="btn btn-secondary navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="<?php echo getURLDir(); ?>admin/">
      <div class="d-flex align-items-center">
        <div class="d-flex align-items-center"><img src="<?php echo getURLDir(); ?>images/wide.png" alt="Atlisware" class="img-fluid" /></div>
      </div>
    </a>
  </div>
  <div class="collapse navbar-collapse order-1 order-lg-0" id="navbarTopCollapse">
    <ul class="navbar-nav navbar-nav-top">
      <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>admin/lookup-lists/index.php"><span class="uil fs-8 me-2 fas fa-list"></span>Lookup Lists</a></li>
      <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>admin/roles/index.php"><span class="uil fs-8 me-2 fas fa-user-shield"></span>Roles</a></li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-nav-icons flex-row">
    <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>" data-bs-toggle="tooltip" title="Back to site"><span data-feather="arrow-left"></span></a></li>
    <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>module/users/index.php?action=logout"><span data-feather="log-out"></span></a></li>
  </ul>
</nav>
