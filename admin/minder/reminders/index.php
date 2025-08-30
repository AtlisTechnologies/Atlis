<?php
require_once __DIR__ . '/../../admin_header.php';
require_permission('minder_reminder','read');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css">
<div class="container-fluid py-4">
  <div id="appCalendar"></div>
</div>
<script src="<?= getURLDir(); ?>vendors/fullcalendar/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('appCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth'
    });
    calendar.render();
  });
</script>
<?php require __DIR__ . '/../../admin_footer.php'; ?>
