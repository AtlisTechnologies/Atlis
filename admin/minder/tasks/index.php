<?php
require '../../admin_header.php';
require_permission('minder_task','read');

// Fetch tasks with start and due dates
$sql = "SELECT id, name, start_date, due_date FROM admin_task ORDER BY start_date";
$tasks = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<h2 class="mb-4">Task Gantt Chart</h2>
<div id="gantt_here" style="width:100%; height:500px;"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  gantt.config.date_format = "%Y-%m-%d";
  var data = {
    data: [
<?php foreach ($tasks as $t):
  if (!$t['start_date']) continue;
  $end = $t['due_date'] ?: $t['start_date'];
  $duration = max(1, (strtotime($end) - strtotime($t['start_date'])) / 86400 + 1);
?>
      {id: <?= (int)$t['id']; ?>, text: <?= json_encode($t['name']); ?>, start_date: "<?= $t['start_date']; ?>", duration: <?= (int)$duration; ?>},
<?php endforeach; ?>
    ]
  };
  gantt.init('gantt_here');
  gantt.parse(data);
});
</script>
<?php require '../../admin_footer.php'; ?>
