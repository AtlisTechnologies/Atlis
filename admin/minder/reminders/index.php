<?php
require_once __DIR__ . '/../../admin_header.php';
require_permission('minder_reminder','read');

$reminders = $pdo->query("SELECT r.id, r.title, r.description, r.remind_at,
       GROUP_CONCAT(DISTINCT CONCAT(p.first_name,' ',p.last_name) SEPARATOR ', ') AS persons,
       GROUP_CONCAT(DISTINCT CONCAT(cp.first_name,' ',cp.last_name) SEPARATOR ', ') AS contractors
FROM admin_minder_reminders r
LEFT JOIN admin_minder_reminders_persons rp ON r.id = rp.reminder_id
LEFT JOIN person p ON rp.person_id = p.id
LEFT JOIN admin_minder_reminders_contractors rc ON r.id = rc.reminder_id
LEFT JOIN module_contractors mc ON rc.contractor_id = mc.id
LEFT JOIN person cp ON mc.person_id = cp.id
GROUP BY r.id
ORDER BY r.remind_at IS NULL, r.remind_at")->fetchAll(PDO::FETCH_ASSOC);

$events = [];
foreach ($reminders as &$r) {
  $r['users'] = trim($r['persons'] . ($r['contractors'] ? ', ' . $r['contractors'] : ''));
  if (!empty($r['remind_at'])) {
    $events[] = ['title'=>$r['title'], 'start'=>$r['remind_at'], 'url'=>'reminder.php?id='.(int)$r['id']];
  }
}
unset($r);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
<div class="container-fluid py-4">
  <ul class="nav nav-tabs" id="reminderTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">List</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" type="button" role="tab">Calendar</button>
    </li>
  </ul>
  <div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="list" role="tabpanel">
      <table class="table">
        <thead><tr><th>Title</th><th>Description</th><th>Remind At</th><th>Users</th></tr></thead>
        <tbody>
          <?php foreach ($reminders as $r): ?>
          <tr>
            <td><a href="reminder.php?id=<?= (int)$r['id']; ?>"><?= e($r['title']); ?></a></td>
            <td><?= e($r['description']); ?></td>
            <td><?= $r['remind_at'] ? e($r['remind_at']) : ''; ?></td>
            <td><?= e($r['users']); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="tab-pane fade" id="calendar" role="tabpanel">
      <div id="appCalendar"></div>
    </div>
  </div>
</div>
<script src="<?= getURLDir(); ?>vendors/fullcalendar/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('appCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: <?= json_encode($events); ?>
    });
    calendar.render();
  });
</script>
<?php require __DIR__ . '/../../admin_footer.php'; ?>
