<nav class="navbar navbar-vertical navbar-expand-lg">
  <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
    <!-- scrollbar removed-->
    <div class="navbar-vertical-content">
      <ul class="navbar-nav flex-column" id="navbarVerticalNav">
        <li class="nav-item">
          <!-- label-->
          <p class="navbar-vertical-label">Apps
          </p>
          <hr class="navbar-vertical-line" />
          <!-- parent pages-->
          <div class="nav-item-wrapper"><a class="nav-link dropdown-indicator label-1" href="#nv-home" role="button" data-bs-toggle="collapse" aria-expanded="false" aria-controls="nv-home">
              <div class="d-flex align-items-center">
                <div class="dropdown-indicator-icon-wrapper"><span class="fas fa-caret-right dropdown-indicator-icon"></span></div><span class="nav-link-icon"><span data-feather="pie-chart"></span></span><span class="nav-link-text">Home</span>
              </div>
            </a>
            <div class="parent-wrapper label-1">
              <ul class="nav collapse parent" data-bs-parent="#navbarVerticalCollapse" id="nv-home">
                <li class="collapsed-nav-item-title d-none">Home
                </li>
                <?php // Placeholder links for real modules ?>
                  <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>/module/agency">
                      <div class="d-flex align-items-center"><span class="nav-link-text">Agencies</span>
                      </div>
                    </a>
                  </li>
                  <?php if (user_has_permission('project','read')): ?>
                  <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>/module/project">
                      <div class="d-flex align-items-center"><span class="nav-link-text">Projects</span>
                      </div>
                    </a>
                  </li>
                  <?php endif; ?>
                  <?php if (user_has_permission('task','read')): ?>
                  <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>/module/task">
                      <div class="d-flex align-items-center"><span class="nav-link-text">Tasks</span>
                      </div>
                    </a>
                  </li>
                  <?php endif; ?>
                  <?php if (user_has_permission('kanban','read')): ?>
                  <li class="nav-item"><a class="nav-link" href="<?php echo getURLDir(); ?>/module/kanban/">
                      <div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fas fa-columns"></span></span><span class="nav-link-text">Kanban</span>
                      </div>
                    </a>
                  </li>
                  <?php endif; ?>
                <?php // Add future module links below ?>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
  
  <div class="navbar-vertical-footer">
    <button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button>
  </div>

</nav>
