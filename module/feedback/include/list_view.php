<?php
// List view for feedback records
?>
<div class="card">
  <div class="card-header">
    <h5 class="mb-0">Feedback List</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-sm table-hover mb-0">
        <thead class="bg-body-tertiary">
          <tr>
            <th>Title</th>
            <th>Type</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($feedback as $row): ?>
            <tr>
              <td><a href="?action=details&id=<?php echo $row['id']; ?>"><?php echo h($row['title']); ?></a></td>
              <td><?php echo h($typeMap[$row['type']]['label'] ?? ''); ?></td>
              <td><?php echo h($row['date_created']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
