<nav class="navbar navbar-vertical navbar-expand-lg">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <div class="navbar-vertical-content">
      <ul class="navbar-nav flex-column" id="navbarVerticalNav">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo getURLDir(); ?>admin/index.php">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="home"></span></span><span class="nav-link-text">Dashboard</span></div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo getURLDir(); ?>admin/lookup-lists/index.php">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span data-feather="list"></span></span><span class="nav-link-text">Lookup Lists</span></div>
          </a>
        </li>
      </ul>
    </div>
  </div>
  <div class="navbar-vertical-footer">
    <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button>
  </div>
</nav>
