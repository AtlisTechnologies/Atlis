<?php require 'admin_header.php'; ?>
<h2 class="mb-4">Admin Dashboard</h2>
<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title"><span class="me-2" data-feather="users"></span>Users</h5>
        <p class="card-text">Manage system users.</p>
        <a href="users/index.php" class="btn btn-phoenix-primary btn-sm">Manage</a>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Lookup Lists</h5>
        <p class="card-text">Manage lookup lists and items.</p>
        <a href="lookup-lists/index.php" class="btn btn-phoenix-primary btn-sm">Manage</a>
      </div>
    </div>
  </div>
</div>
<?php require 'admin_footer.php'; ?>
