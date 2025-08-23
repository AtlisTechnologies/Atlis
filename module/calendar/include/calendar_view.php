<div class="row mb-3">
  <div class="col">
    <a href="index.php?action=create" class="btn btn-primary">Create Calendar</a>
  </div>
</div>
<div id="calendar"></div>
<script src="<?php echo getURLDir(); ?>vendors/fullcalendar/index.global.min.js"></script>
<script>
  window.addEventListener('load', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: <?php echo json_encode(array_map(function($e){
        return [
          'title' => $e['title'],
          'start' => $e['start_time'],
          'end'   => $e['end_time']
        ];
      }, $events)); ?>
    });
    calendar.render();
  });
</script>
