<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />

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

<ul class="nav nav-pills mb-3" id="calendarTabs">
  <li class="nav-item"><button class="nav-link active" data-scope="shared">Shared Calendar</button></li>
  <li class="nav-item"><button class="nav-link" data-scope="mine">My Calendar</button></li>
</ul>

<div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-y border-translucent">
  <div class="row py-3 gy-3 gx-0">
    <div class="col-6 col-md-4 order-1 d-flex align-items-center">
      <button class="btn btn-sm btn-phoenix-primary px-4" data-event="today">Today</button>
    </div>
    <div class="col-12 col-md-4 order-md-1 d-flex align-items-center justify-content-center">
      <button class="btn icon-item icon-item-sm shadow-none text-body-emphasis p-0" type="button" data-event="prev" title="Previous"><span class="fas fa-chevron-left"></span></button>
      <h3 class="px-3 text-body-emphasis fw-semibold calendar-title mb-0"></h3>
      <button class="btn icon-item icon-item-sm shadow-none text-body-emphasis p-0" type="button" data-event="next" title="Next"><span class="fas fa-chevron-right"></span></button>
    </div>
    <div class="col-6 col-md-4 ms-auto order-1 d-flex justify-content-end">
      <div>
        <div class="btn-group btn-group-sm" role="group">
          <button class="btn btn-phoenix-secondary active-view" data-fc-view="dayGridMonth">Month</button>
          <button class="btn btn-phoenix-secondary" data-fc-view="timeGridWeek">Week</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="calendar-outline mt-6 mb-9" id="appCalendar"></div>

<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="addEventForm" autocomplete="off">
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
              <input class="form-control datetimepicker" id="eventStartDate" type="text" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventStartDate">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" id="eventEndDate" type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventEndDate">Ends at</label>
            </div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="eventAllDay" name="allDay" />
            <label class="form-check-label" for="eventAllDay">All day event</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" id="eventDescription" placeholder="Description" name="description" style="height: 100px"></textarea>
            <label for="eventDescription">Description</label>
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
        <input type="hidden" name="eventId" />
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
              <input class="form-control datetimepicker" type="text" name="startDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" type="text" name="endDate" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Ends at</label>
            </div>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="allDay" />
            <label class="form-check-label">All day event</label>
          </div>
          <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Description" name="description" style="height: 100px"></textarea>
            <label>Description</label>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center border-0">
          <button class="btn btn-danger me-auto" type="button" id="deleteEventBtn">Delete</button>
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

  let currentScope = 'shared';
  const calendarEl = document.getElementById('appCalendar');
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: false,
    events: {
      url: '<?php echo getURLDir(); ?>module/calendar/functions/list.php',
      extraParams: () => ({ scope: currentScope })
    },
    eventClick: function(info) {
      const editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
      const form = document.getElementById('editEventForm');
      form.eventId.value = info.event.id;
      form.title.value = info.event.title;
      form.startDate.value = info.event.startStr.replace('T', ' ').substring(0,16);
      form.endDate.value = info.event.end ? info.event.end.toISOString().slice(0,16) : '';
      form.allDay.checked = info.event.allDay;
      form.description.value = info.event.extendedProps.description || '';
      editModal.show();
    },
    dateClick: function(info) {
      const addModal = new bootstrap.Modal(document.getElementById('addEventModal'));
      addModal.show();
      document.querySelector('#addEventForm [name="startDate"]').value = info.dateStr + ' 00:00';
    }
  });
  calendar.render();

  document.querySelector('[data-event="today"]').addEventListener('click', () => { calendar.today(); });
  document.querySelector('[data-event="prev"]').addEventListener('click', () => { calendar.prev(); });
  document.querySelector('[data-event="next"]').addEventListener('click', () => { calendar.next(); });
  document.querySelectorAll('[data-fc-view]').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('[data-fc-view]').forEach(b => b.classList.remove('active-view'));
      this.classList.add('active-view');
      calendar.changeView(this.getAttribute('data-fc-view'));
    });
  });

  document.querySelectorAll('#calendarTabs [data-scope]').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('#calendarTabs .nav-link').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      currentScope = this.getAttribute('data-scope');
      calendar.refetchEvents();
    });
  });

  document.getElementById('addEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/create.php', {
      method: 'POST',
      body: data
    })
    .then(resp => resp.json())
    .then(res => {
      if (res.success) {
        calendar.refetchEvents();
        e.target.reset();
        bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
      }
    });
  });

  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/update.php', {
      method: 'POST',
      body: data
    })
    .then(resp => resp.json())
    .then(res => {
      if (res.success) {
        calendar.refetchEvents();
        bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
      }
    });
  });

  document.getElementById('deleteEventBtn').addEventListener('click', function() {
    const form = document.getElementById('editEventForm');
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/delete.php', {
      method: 'POST',
      body: new URLSearchParams({ id: form.eventId.value })
    })
    .then(resp => resp.json())
    .then(res => {
      if (res.success) {
        calendar.refetchEvents();
        bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
      }
    });
  });
});
</script>
