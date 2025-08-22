<?php
// List view of agencies
?>
<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive scrollbar">
      <table class="table mb-0">
        <thead class="table-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody class="list">
          <?php foreach ($agencies as $agency): ?>
            <tr>
              <td class="align-middle name"><?php echo htmlspecialchars($agency['name']); ?></td>
              <td class="align-middle status">
                <?= render_status_badge($statusList, $agency['status']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
