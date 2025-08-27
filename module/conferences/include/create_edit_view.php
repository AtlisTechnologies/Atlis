<?php
$editing = !empty($conference);
$actionUrl = $editing ? 'functions/update.php' : 'functions/create.php';
?>
<div class="container py-4">
  <h2 class="mb-4"><?= $editing ? 'Edit Conference' : 'Create Conference' ?></h2>
  <?php require 'form.php'; ?>
</div>
