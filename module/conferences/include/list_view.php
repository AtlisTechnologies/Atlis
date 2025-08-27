<?php
?>
<div class="p-4">
  <h2 class="mb-4">Conferences<span class="text-body-tertiary fw-normal">(<?= count($conferences ?? []) ?>)</span></h2>
  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Start</th>
        <th>Location</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($conferences)): ?>
        <?php foreach ($conferences as $c): ?>
          <tr>
            <td><a href="index.php?action=details&id=<?= (int)$c['id'] ?>"><?= h($c['name']) ?></a></td>
            <td><?= h($c['start_datetime']) ?></td>
            <td><?= h($c['venue']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="3" class="text-center">No conferences found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
  <?php if (user_has_permission('conference','create')): ?>
    <a class="btn btn-success" href="index.php?action=create-edit">Create Conference</a>
  <?php endif; ?>
</div>
