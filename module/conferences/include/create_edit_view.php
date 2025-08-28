<?php
 $editing = !empty($conference);
 $actionUrl = $editing ? 'functions/update.php' : 'functions/create.php';
?>
<div class="container py-4">
  <h2 class="mb-4"><?= $editing ? 'Edit Conference' : 'Create a Conference' ?></h2>
  <div class="card">
    <div class="card-body">
      <?php require 'form.php'; ?>
    </div>
  </div>
</div>
