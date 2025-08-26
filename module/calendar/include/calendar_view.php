<?php
$calendars = [];
$sql = 'SELECT id, name, is_private, user_id = :uid AS owned FROM module_calendar WHERE user_id = :uid OR is_private = 0 ORDER BY owned DESC, name';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $this_user_id, PDO::PARAM_INT);
$stmt->execute();
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
$owned_calendar_ids = array_column(array_filter($calendars, fn($c) => !empty($c['owned'])), 'id');
$owned_calendars = array_values(array_filter($calendars, fn($c) => !empty($c['owned'])));
$owns_calendar = !empty($owned_calendar_ids);

$selected_calendar_id = $_SESSION['selected_calendar_id'] ?? 0;
$default_add_calendar_id = in_array($selected_calendar_id, $owned_calendar_ids, true)
  ? $selected_calendar_id
  : ($owned_calendar_ids[0] ?? 0);

$event_types = get_lookup_items($pdo, 37);

$default_event_type_id = $event_types[0]['id'] ?? 0;

?>
<div class="row g-0 mb-4 align-items-center">
  <div class="col-5 col-md-6">
    <h4 class="mb-0 text-body-emphasis fw-bold fs-md-6"><span class="calendar-day d-block d-md-inline mb-1"></span><span class="px-3 fw-thin text-body-quaternary d-none d-md-inline">|</span><span class="calendar-date"></span></h4>
  </div>
  <div class="col-7 col-md-6 d-flex justify-content-end align-items-center">
    <?php if (!empty($calendars)) { ?>
      <div class="form-floating form-floating-advance-select me-2">
        <label for="calendarSelect">Calendars Displayed</label>
        <select id="calendarSelect"
                class="form-select"
                multiple
                data-choices="data-choices"
                data-options='{"removeItemButton":true}'>
          <?php foreach ($calendars as $cal) { ?>
            <?php $cal_label = $cal['name'] . (!empty($cal['is_private']) ? ' (Private)' : ''); ?>
            <option value="<?php echo $cal['id']; ?>" selected><?php echo e($cal_label); ?></option>
          <?php } ?>
        </select>
      </div>
    <?php } ?>
    <?php if ($owns_calendar && user_has_permission('calendar','create')) { ?>
      <a class="btn btn-outline-primary btn-sm me-2" href="index.php?action=create">Create Calendar</a>
    <?php } ?>

    <?php if ($owns_calendar) { ?>
      <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addEventModal">
        <span class="fas fa-plus pe-2 fs-10"></span>Add Event
      </button>
    <?php } else { ?>
      <a class="btn btn-primary btn-sm" href="index.php?action=create">Create Calendar</a>
    <?php } ?>

  </div>
</div>

<div id="calendar" class="calendar-outline mt-6 mb-9"></div>

<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="addEventForm" autocomplete="off">
        <div class="mb-3">
          <label class="form-label d-block">Calendar</label>
          <?php foreach ($owned_calendars as $cal): ?>
            <div class="form-check">
              <input class="form-check-input"
                     type="radio"
                     name="calendar_id"
                     id="addCal<?= $cal['id']; ?>"
                     value="<?= $cal['id']; ?>"
                     <?= $cal['id'] == $default_add_calendar_id ? 'checked' : ''; ?>>
              <label class="form-check-label" for="addCal<?= $cal['id']; ?>">
                <?= h($cal['name']); ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
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
              <input class="form-control datetimepicker" id="eventStart" type="text" name="start_time" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventStart">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" id="eventEnd" type="text" name="end_time" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6" for="eventEnd">Ends at</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="addEventType">Event Type</label>
            <select class="form-select" id="addEventType" name="event_type_id">
              <?php foreach ($event_types as $et): ?>
                <option value="<?= (int)$et['id']; ?>" class="text-<?= h($et['color_class']); ?>" data-icon="<?= h($et['icon_class']); ?>"><?= h($et['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="addEventPrivate" name="is_private" value="1">
            <label class="form-check-label" for="addEventPrivate">Private</label>

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
              <input class="form-control datetimepicker" type="text" name="start_time" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Starts at</label>
            </div>
          </div>
          <div class="flatpickr-input-container mb-3">
            <div class="form-floating">
              <input class="form-control datetimepicker" type="text" name="end_time" placeholder="yyyy/mm/dd hh:mm" data-options='{"disableMobile":true,"enableTime":"true","dateFormat":"Y-m-d H:i"}' />
              <label class="ps-6">Ends at</label>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="editEventType">Event Type</label>
            <select class="form-select" id="editEventType" name="event_type_id">
              <?php foreach ($event_types as $et): ?>
                <option value="<?= (int)$et['id']; ?>" class="text-<?= h($et['color_class']); ?>" data-icon="<?= h($et['icon_class']); ?>"><?= h($et['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="editEventPrivate" name="is_private" value="1">
            <label class="form-check-label" for="editEventPrivate">Private</label>

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
  const defaultEventTypeId = <?php echo (int)$default_event_type_id; ?>;
  const ownedCalendarIds = <?php echo json_encode(array_values(array_map('intval', $owned_calendar_ids))); ?>;

  const calendarEl = document.getElementById('calendar');
  const addEventForm = document.getElementById('addEventForm');
  const listUrl = '<?php echo getURLDir(); ?>module/calendar/functions/list.php';

  const VISIBILITY_PUBLIC = 198;
  const VISIBILITY_PRIVATE = 199;

  function isEventPrivate(props) {
    if ('visibility_id' in props) {
      return String(props.visibility_id) === String(VISIBILITY_PRIVATE);
    }
    return String(props.is_private) === '1';
  }

  function getCalendarIds() {
    const sel = document.getElementById('calendarSelect');
    if (!sel) return [];
    return Array.from(sel.selectedOptions).map(opt => opt.value);
  }

  function getCalendarId() {
    const ids = getCalendarIds();
    return ids.length ? ids[0] : defaultCalendarId;
  }

  function selectCalendarRadio(form, cid) {
    const radio = form.querySelector(`input[name="calendar_id"][value="${cid}"]`);
    if (radio) radio.checked = true;
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',

    events: function(fetchInfo, successCallback, failureCallback) {
      const ids = getCalendarIds();
      const url = ids.length ? `${listUrl}?calendar_ids=${ids.join(',')}` : listUrl;
      fetch(url)
        .then(r => {
          if (!r.ok) throw new Error('HTTP ' + r.status);
          return r.json();
        })
        .then(data => successCallback(data))
        .catch(err => {
          console.error('Failed to load events', err);
          alert('Failed to load events: ' + err.message);
          if (failureCallback) failureCallback(err);
        });
    },

    eventClick: function(info) {
      const ownerId = info.event.extendedProps.user_id ?? info.event.extendedProps.calendar_user_id;
      if (ownerId !== undefined && parseInt(ownerId, 10) !== currentUserId && !isAdmin) {
        alert('You do not have permission to edit this event.');
        return;
      }
      const form = document.getElementById('editEventForm');
      // Populate edit form with selected event details
      form.id.value = info.event.id;
      form.title.value = info.event.title;
      form.start_time.value = dayjs(info.event.start).format('YYYY-MM-DD HH:mm');
      form.end_time.value = info.event.end ? dayjs(info.event.end).format('YYYY-MM-DD HH:mm') : '';
      form.event_type_id.value = info.event.extendedProps.event_type_id || defaultEventTypeId;
      form.is_private.checked = isEventPrivate(info.event.extendedProps);
      bootstrap.Modal.getOrCreateInstance(document.getElementById('editEventModal')).show();
    },
    dateClick: function(info) {
      const form = addEventForm;
      form.start_time.value = dayjs(info.date).format('YYYY-MM-DD HH:mm');
      form.end_time.value = '';
      form.event_type_id.value = defaultEventTypeId;
      form.is_private.checked = false;
      selectCalendarRadio(form, getCalendarId());
      bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show();
    }
  });
  calendar.render();

  window.addEventListener('message', function(e) {
    if (e.data === 'calendarLinked') {
      window.location.reload();
    }
  });

  const calSelect = document.getElementById('calendarSelect');
  if (calSelect) {
    calSelect.addEventListener('change', function() {
      calendar.refetchEvents();
    });
  }

  document.getElementById('addEventModal').addEventListener('show.bs.modal', function() {
    selectCalendarRadio(addEventForm, getCalendarId());
  });

  addEventForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const cid = parseInt(form.querySelector('input[name="calendar_id"]:checked').value, 10);
    if (!ownedCalendarIds.includes(cid)) {
      alert('Please select one of your calendars before adding an event.');
      return;
    }
    const fd = new FormData(form);
    fd.append('visibility_id', form.is_private.checked ? VISIBILITY_PRIVATE : VISIBILITY_PUBLIC);
    fd.delete('is_private');
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/create.php', {
      method: 'POST',
      body: fd
    })
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(data => {
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('addEventModal')).hide();
        this.reset();
        calendar.refetchEvents();
      } else {
        alert(data.error || 'An error occurred while adding the event.');
      }
    })
    .catch(err => {
      console.error('Failed to add event', err);
      alert('Failed to add event: ' + err.message);
    });
  });

  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    this.calendar_id.value = getCalendarId();
    const fd = new FormData(this);
    fd.append('visibility_id', this.is_private.checked ? VISIBILITY_PRIVATE : VISIBILITY_PUBLIC);
    fd.delete('is_private');
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/update.php', {
      method: 'POST',
      body: fd
    })
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(data => {
      if (data.success) {
        bootstrap.Modal.getInstance(document.getElementById('editEventModal')).hide();
        calendar.refetchEvents();
      } else {
        alert(data.error || 'An error occurred while updating the event.');
      }
    })
    .catch(err => {
      console.error('Failed to update event', err);
      alert('Failed to update event: ' + err.message);
    });
  });
});
</script>
