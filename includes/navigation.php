<nav class="navbar navbar-top fixed-top navbar-expand-lg" id="navbarCombo" data-navbar-top="combo" data-move-target="#navbarVerticalNav" data-navbar-appearance="darker">
  <div class="navbar-logo">

    <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="<?php echo getURLDir(); ?>">
      <div class="d-flex align-items-center">
        <div class="d-flex align-items-center"><img src="<?php echo getURLDir(); ?>images/wide.png" alt="Atlisware" class="img-fluid" />
        </div>
      </div>
    </a>
  </div>

  <div class="collapse navbar-collapse navbar-top-collapse order-1 order-lg-0 justify-content-center" id="navbarTopCollapse">
    <ul class="navbar-nav navbar-nav-top">

      <?php // HOME NAV LINK ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle lh-1" href="<?php echo getURLDir(); ?>#home">
          <span class="uil fs-8 me-2 fas fa-home"></span>Home
        </a>
      </li>
      <?php // ================ ?>
      <?php // END HOME NAV LINK ?>
      <?php // ================ ?>


      <?php // AGENCIES NAV LINK ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle lh-1" href="<?php echo getURLDir(); ?>/module/agencies">
          <span class="uil fs-8 me-2 far fa-building"></span>Agencies</a>
      </li>
      <?php // ================ ?>
      <?php // END PROJECTS NAV LINK ?>
      <?php // ================ ?>


      <?php // PROJECTS NAV LINK ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle lh-1" href="<?php echo getURLDir(); ?>/module/projects/index.php?action=all">
          <span class="uil fs-8 me-2 fas fa-project-diagram"></span>Projects</a>
      </li>
      <?php // ================ ?>
      <?php // END PROJECTS NAV LINK ?>
      <?php // ================ ?>


      <?php // TASKS NAV LINK ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle lh-1" href="<?php echo getURLDir(); ?>/module/tasks">
          <span class="uil fs-8 me-2 fas fa-tasks"></span>Tasks</a>
      </li>
      <?php // ================ ?>
      <?php // END TASKS NAV LINK ?>
      <?php // ================ ?>


      <?php // KANBAN NAV LINK ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle lh-1" href="<?php echo getURLDir(); ?>/module/kanban">
          <span class="uil fs-8 me-2 fas fa-columns"></span>Kanban</a>
      </li>
      <?php // ================ ?>
      <?php // END KANBAN NAV LINK ?>
      <?php // ================ ?>

    </ul>
  </div>

<?php // END OF THE MIDDLE OF TOP NAV ?>
<?php // END OF THE MIDDLE OF TOP NAV ?>
<?php // END OF THE MIDDLE OF TOP NAV ?>
<?php // END OF THE MIDDLE OF TOP NAV ?>
<?php // END OF THE MIDDLE OF TOP NAV ?>



  <?php if(isset($_SESSION['user_logged_in'])){ ?>
    <ul class="navbar-nav navbar-nav-icons flex-row">
      <li class="nav-item dropdown">
        <a class="nav-link" href="#" style="min-width: 2.25rem" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-bs-auto-close="outside"><span class="d-block" style="height:20px;width:20px;"><span data-feather="bell" style="height:20px;width:20px;"></span></span></a>

        <div class="dropdown-menu dropdown-menu-end notification-dropdown-menu py-0 shadow border navbar-dropdown-caret" id="navbarDropdownNotfication" aria-labelledby="navbarDropdownNotfication">
          <div class="card position-relative border-0">
            <div class="card-header p-2">
              <div class="d-flex justify-content-between">
                <h5 class="text-body-emphasis mb-0">Notifications</h5>
                <button class="btn btn-link p-0 fs-9 fw-normal" type="button">Mark all as read</button>
              </div>
            </div>
            <div class="card-body p-0">
              <div id="notification-container" class="scrollbar-overlay" style="height: 27rem;">
                <!-- Notifications will be loaded here dynamically -->
              </div>
            </div>
            <div class="card-footer p-0 border-top border-translucent border-0">
              <div class="my-2 text-center fw-bold fs-10 text-body-tertiary text-opactity-85"><a class="fw-bolder" href="pages/notifications.html">Notification history</a></div>
            </div>
          </div>
        </div>
      </li>

      <li class="nav-item dropdown"><a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-l ">
            <img class="rounded-circle " src="<?php echo getURLDir(); ?>module/user/uploads/dave_2.jpg" alt="user" />
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border" aria-labelledby="navbarDropdownUser">
          <div class="card position-relative border-0">
            <div class="card-body p-0">
              <div class="text-center pt-4 pb-3">
                <div class="avatar avatar-xl ">
                  <img class="rounded-circle " src="<?php echo getURLDir(); ?>assets/img/team/72x72/57.webp" alt="" />

                </div>
                <h6 class="mt-2 text-body-emphasis">Jerry Seinfield</h6>
              </div>
              <div class="mb-3 mx-3">
                <input class="form-control form-control-sm" id="statusUpdateInput" type="text" placeholder="Update your status" />
              </div>
            </div>
            <div class="overflow-auto scrollbar" style="height: 10rem;">
              <ul class="nav d-flex flex-column mb-2 pb-1">
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="user"></span><span>Profile</span></a></li>
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"><span class="me-2 text-body align-bottom" data-feather="pie-chart"></span>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="lock"></span>Posts &amp; Activity</a></li>
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="settings"></span>Settings &amp; Privacy </a></li>
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="help-circle"></span>Help Center</a></li>
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="globe"></span>Language</a></li>
              </ul>
            </div>
            <div class="card-footer p-0 border-top border-translucent">
              <ul class="nav d-flex flex-column my-3">
                <li class="nav-item"><a class="nav-link px-3 d-block" href="#!"> <span class="me-2 text-body align-bottom" data-feather="user-plus"></span>Add another account</a></li>
              </ul>
              <hr />
              <div class="px-3"> <a class="btn btn-phoenix-secondary d-flex flex-center w-100" href="#!"> <span class="me-2" data-feather="log-out"> </span>Sign out</a></div>
              <div class="my-2 text-center fw-bold fs-10 text-body-quaternary"><a class="text-body-quaternary me-1" href="#!">Privacy policy</a>&bull;<a class="text-body-quaternary mx-1" href="#!">Terms</a>&bull;<a class="text-body-quaternary ms-1" href="#!">Cookies</a></div>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <a href="<?php echo getURLDir(); ?>module/users/index.php?action=logout" class="btn btn-sm btn-outline-warning btn-flat float-end ms-4">Logout</a>

    <?php if($_SESSION['this_user_type'] && $this_user_type == 'ADMIN'){ ?>
      <li class="nav-item">
        <a href="<?php echo getURLDir(); ?>admin" class="nav-link btn btn-sm btn-outline-danger text-danger font-weight-bold">Admin</a>
      </li>
    <?php } ?>

  <?php // END IF USER IS AUTHENTICATED ?>
  <?php } ?>

  <?php // USER IS NOT AUTHENTICATED OR LOGGED IN
  if(!isset($_SESSION['user_logged_in'])){ ?>
    <?php // LOGIN BUTTON ?>

    <li class="nav-item mr-4">
      <a href="<?php echo getURLDir(); ?>module/users/index.php?action=login" class="nav-link btn btn-sm btn-success font-weight-bold text-white">Login</a>
    </li>
  <?php } ?>

</nav>
