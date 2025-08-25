<?php
$visibilities = $pdo->query("SELECT id,label FROM lookup_list_items WHERE list_id=38 ORDER BY sort_order,label")->fetchAll(PDO::FETCH_ASSOC);
$selected_calendar_id = $_SESSION['selected_calendar_id'] ?? 0;
$default_visibility_id = $visibilities[0]['id'] ?? 0;
?>
<div class="row g-0 mb-4 align-items-center">
  <div class="col-5 col-md-6">
    <h4 class="mb-0 text-body-emphasis fw-bold fs-md-6"><span class="calendar-day d-block d-md-inline mb-1"></span><span class="px-3 fw-thin text-body-quaternary d-none d-md-inline">|</span><span class="calendar-date"></span></h4>
  </div>
  <div class="col-7 col-md-6 d-flex justify-content-end">
    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">
      <span class="fas fa-plus pe-2 fs-10"></span>Add Event
    </button>
  </div>
</div>

<div id="calendar" class="calendar-outline mt-6 mb-9"></div>

<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="addEventForm" autocomplete="off">
        <input type="hidden" name="calendar_id" value="<?= (int)$selected_calendar_id; ?>" />
        <div class="modal-header px-card border-0">
          <h5 class="mb-0 lh-sm text-body-highlight">Add Event</h5>
          <button class="btn p-1 fs-10 text-body" type="button" data-bs-dismiss="modal" aria-label="Close">DISCARD</button>
        </div>
        <div class="modal-body p-card py-0">
          <div class="form-floating mb-3">
            <input class="form-control" id="eventTitle" type="text" name="title" required="required" placeholder="Event title" />
            <label for="eventTitle">Title</label>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" id="eventStart" type="text" name="start_date" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventStart">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" id="eventEnd" type="text" name="end_date" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventEnd">Ends at</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="addEventVisibility">Visibility</label>
            <select class="form-select" id="addEventVisibility" name="visibility_id">
              <?php foreach ($visibilities as $v): ?>
                <option value="<?= (int)$v['id']; ?>"><?= h($v['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center border-0">
          <button class="btn btn-primary px-4" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="editEventForm" autocomplete="off">
        <input type="hidden" name="id" />
        <input type="hidden" name="calendar_id" value="<?= (int)$selected_calendar_id; ?>" />
        <div class="modal-header px-card border-0">
          <h5 class="mb-0 lh-sm text-body-highlight">Edit Event</h5>
          <button class="btn p-1 fs-10 text-body" type="button" data-bs-dismiss="modal" aria-label="Close">CLOSE</button>
        </div>
        <div class="modal-body p-card py-0">
          <div class="form-floating mb-3">
            <input class="form-control" type="text" name="title" required="required" placeholder="Event title" />
            <label>Title</label>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" type="text" name="start_date" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" type="text" name="end_date" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Ends at</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="editEventVisibility">Visibility</label>
            <select class="form-select" id="editEventVisibility" name="visibility_id">
              <?php foreach ($visibilities as $v): ?>
                <option value="<?= (int)$v['id']; ?>"><?= h($v['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center border-0">
          <button class="btn btn-primary px-4" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo getURLDir(); ?>vendors/fullcalendar/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  const now = new Date();
  document.querySelector('.calendar-day').textContent = dayNames[now.getDay()];
  document.querySelector('.calendar-date').textContent = now.toLocaleDateString('en-US', {year:'numeric', month:'short', day:'numeric'});

  const defaultCalendarId = <?php echo (int)$selected_calendar_id; ?>;
  const defaultVisibilityId = <?php echo (int)$default_visibility_id; ?>;
  const calendarEl = document.getElementById('calendar');

  function getCalendarId() {
    const sel = document.getElementById('calendarSelect');
    return sel ? sel.value : defaultCalendarId;
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: '<?php echo getURLDir(); ?>module/calendar/functions/list.php',
    eventClick: function(info) {
      const form = document.getElementById('editEventForm');
      form.id.value = info.event.id;
      form.title.value = info.event.title;
      form.start.value = dayjs(info.event.start).format('YYYY-MM-DD HH:mm');
      form.end.value = info.event.end ? dayjs(info.event.end).format('YYYY-MM-DD HH:mm') : '';
      form.is_private.checked = !!Number(info.event.extendedProps.is_private);
      bootstrap.Modal.getOrCreateInstance(document.getElementById('editEventModal')).show();
    },
    dateClick: function(info) {
      const form = document.getElementById('addEventForm');
      form.start_date.value = dayjs(info.date).format('YYYY-MM-DD HH:mm');
      form.end_date.value = '';
      form.visibility_id.value = defaultVisibilityId;
      form.calendar_id.value = getCalendarId();
      bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show();
    }
  });
  calendar.render();

  document.getElementById('addEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    this.calendar_id.value = getCalendarId();
    const fd = new FormData(this);
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/create.php', {
      method: 'POST',
      body: fd
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
        this.reset();
        calendar.refetchEvents();
      }
    });
  });

  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    this.calendar_id.value = getCalendarId();
    const fd = new FormData(this);
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/update.php', {
      method: 'POST',
      body: fd
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
        calendar.refetchEvents();
      }

    });
  });
});
</script>
