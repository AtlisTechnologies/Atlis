<?php
$calendars = [];
$sql = 'SELECT id, name, is_private, is_default, user_id = :uid AS owned FROM module_calendar WHERE user_id = :uid OR is_private = 0 ORDER BY owned DESC, name';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $this_user_id, PDO::PARAM_INT);
$stmt->execute();
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
$owned_calendar_ids = array_column(array_filter($calendars, fn($c) => !empty($c['owned'])), 'id');
$owned_calendars = array_values(array_filter($calendars, fn($c) => !empty($c['owned'])));
$owns_calendar = !empty($owned_calendar_ids);


$user_default_calendar_id = get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_DEFAULT') ?? 0;
$selected_calendar_id = $_SESSION['selected_calendar_id'] ?? $user_default_calendar_id;
$default_add_calendar_id = in_array($selected_calendar_id, $owned_calendar_ids, true)
    ? $selected_calendar_id
    : ($user_default_calendar_id ?: ($owned_calendar_ids[0] ?? 0));

$user_public_calendar_id = 0;
foreach ($owned_calendars as $cal) {
    if ((int)$cal['is_private'] === 0) {
        $user_public_calendar_id = (int)$cal['id'];
        break;
    }
}

$event_types = get_lookup_items($pdo, 'CALENDAR_EVENT_TYPE');

$default_event_type_id = get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_EVENT_TYPE_DEFAULT') ?? 0;

?>

<div class="row g-0">
  <div class="col-lg-2 col-md-3 px-0">
    <?php if (user_has_permission('calendar','create')): ?>
      <div class="mb-3 text-center">
        <a href="index.php?action=create" class="btn btn-atlis w-100">Create Calendar</a>
      </div>
    <?php endif; ?>
    <div id="calendarSidebar"></div>
  </div>
  <div class="col px-3">
    <div class="d-flex justify-content-center mb-3">
      <button class="btn btn-success" type="button" id="openAddEvent" <?= $owns_calendar ? '' : 'disabled data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create a calendar to add events"'; ?>>Add Event</button>
    </div>
    <div id="calendarAlert"></div>
    <div id="calendarSpinner" class="spinner-border text-primary" role="status" style="display:none;">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div id="calendar" class="calendar-outline"></div>
  </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="addEventForm" autocomplete="off">

        <input type="hidden" name="calendar_id" value="<?= (int)$default_add_calendar_id; ?>" />

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
              <option value="" <?= $default_event_type_id ? '' : 'selected'; ?>>Select type</option>
              <?php foreach ($event_types as $et): ?>
                <option value="<?= (int)$et['id']; ?>" class="text-<?= h($et['color_class']); ?>" data-icon="<?= h($et['icon_class']); ?>"<?= (int)$et['id'] === (int)$default_event_type_id ? ' selected' : ''; ?>><?= h($et['label']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <?php if ($owns_calendar) { ?>
            <div class="mb-3">
              <label class="form-label d-block mb-2">Calendar</label>
              <?php foreach ($calendars as $cal): ?>
                <?php if (!empty($cal['owned'])): ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="calendar_id_radio" id="addEventCal<?= (int)$cal['id']; ?>" value="<?= (int)$cal['id']; ?>"<?= (int)$cal['id'] === (int)$default_add_calendar_id ? ' checked' : ''; ?>>
                    <label class="form-check-label" for="addEventCal<?= (int)$cal['id']; ?>"><?= e($cal['name']); ?></label>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          <?php } ?>

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
              <option value="">Select type</option>
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
  const dayEl = document.querySelector('.calendar-day');
  if (dayEl) {
    dayEl.textContent = dayNames[now.getDay()];
  }
  const dateEl = document.querySelector('.calendar-date');
  if (dateEl) {
    dateEl.textContent = now.toLocaleDateString('en-US', {year:'numeric', month:'short', day:'numeric'});
  }

  const defaultCalendarId = <?php echo (int)$user_default_calendar_id; ?>;
  const defaultAddCalendarId = <?php echo (int)$default_add_calendar_id; ?>;
  const defaultEventTypeId = <?php echo (int)$default_event_type_id; ?>;
  const ownedCalendarIds = <?php echo json_encode(array_values(array_map('intval', $owned_calendar_ids))); ?>;
  const userPublicCalendarId = <?php echo (int)$user_public_calendar_id; ?>;
  const calendarEl = document.getElementById('calendar');
  const addEventForm = document.getElementById('addEventForm');
  const addEventModalEl = document.getElementById('addEventModal');
  const openAddEventBtn = document.getElementById('openAddEvent');
  const listUrl = '<?php echo getURLDir(); ?>module/calendar/functions/list.php';
  const VISIBILITY_PUBLIC = 198;
  const VISIBILITY_PRIVATE = 199;
  const calendarSpinner = document.getElementById('calendarSpinner');
  const alertPlaceholder = document.getElementById('calendarAlert');
  const calendarsData = <?php echo json_encode($calendars); ?>;
  const currentUserId = <?= (int)$this_user_id ?>;
  const isAdmin = <?= user_has_role('Admin') ? 'true' : 'false' ?>;

  function showAlert(message, type = 'danger') {
    if (!alertPlaceholder) return;
    alertPlaceholder.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}` +
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }

  if (openAddEventBtn && openAddEventBtn.disabled) {
    bootstrap.Tooltip.getOrCreateInstance(openAddEventBtn);
  }

  function isEventPrivate(props) {
    if ('visibility_id' in props) {
      return String(props.visibility_id) === String(VISIBILITY_PRIVATE);
    }
    return String(props.is_private) === '1';
  }

  function getCalendarIds() {
    const cbs = document.querySelectorAll('.calendar-checkbox:checked');
    return Array.from(cbs).map(cb => cb.value);
  }

  function getCalendarId() {
    const ids = getCalendarIds();
    const cid = ids.length ? ids[0] : userPublicCalendarId;
    return ownedCalendarIds.includes(parseInt(cid, 10)) ? cid : defaultAddCalendarId;
  }

  function selectCalendarRadio(form, cid) {
    const radios = form ? form.querySelectorAll('input[name="calendar_id_radio"]') : [];
    radios.forEach(r => {
      r.checked = String(r.value) === String(cid);
    });
    if (form && form.calendar_id) {
      form.calendar_id.value = cid;
    }
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',

    events: function(fetchInfo, successCallback, failureCallback) {
      const ids = getCalendarIds();
      const fetchIds = ids.length ? ids : [userPublicCalendarId];
      const url = `${listUrl}?calendar_ids=${fetchIds.join(',')}`;
      if (calendarSpinner) calendarSpinner.style.display = 'block';
      fetch(url)
        .then(r => {
          if (!r.ok) throw new Error('HTTP ' + r.status);
          return r.json();
        })
        .then(data => {
          if (calendarSpinner) calendarSpinner.style.display = 'none';
          successCallback(data);
        })
        .catch(err => {
          if (calendarSpinner) calendarSpinner.style.display = 'none';
          console.error('Failed to load events', err);
          showAlert('Failed to load events: ' + err.message);
          if (failureCallback) failureCallback(err);
        });
    },

    eventClick: function(info) {
      const ownerId = parseInt(info.event.extendedProps.user_id ?? info.event.extendedProps.calendar_user_id, 10);
      if (ownerId !== currentUserId && !isAdmin) {
        alert('You do not have permission to edit this event.');
        return;
      }
      const form = document.getElementById('editEventForm');
      // Populate edit form with selected event details
      form.id.value = info.event.id;
      form.title.value = info.event.title;
      form.start_time.value = dayjs(info.event.start).format('YYYY-MM-DD HH:mm');
      form.end_time.value = info.event.end ? dayjs(info.event.end).format('YYYY-MM-DD HH:mm') : '';
      form.event_type_id.value = info.event.extendedProps.event_type_id || defaultEventTypeId || '';
      form.is_private.checked = isEventPrivate(info.event.extendedProps);
      bootstrap.Modal.getOrCreateInstance(document.getElementById('editEventModal')).show();
    },
    dateClick: function(info) {
      const form = addEventForm;
      form.start_time.value = dayjs(info.date).format('YYYY-MM-DD HH:mm');
      form.end_time.value = '';
      form.event_type_id.value = defaultEventTypeId || '';
      form.is_private.checked = false;
      selectCalendarRadio(form, getCalendarId());
      bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show();
    }
    });
  function initSidebar() {
    const sidebar = document.getElementById('calendarSidebar');
    sidebar.innerHTML = '';
    const myCals = calendarsData.filter(c => parseInt(c.owned, 10));
    const otherCals = calendarsData.filter(c => !parseInt(c.owned, 10));
    if (myCals.length) {
      const hMy = document.createElement('h6');
      hMy.textContent = 'My Calendars';
      sidebar.appendChild(hMy);
      myCals.forEach(cal => {
        const div = document.createElement('div');
        div.className = 'form-check form-check-lg';
        div.innerHTML = `<input class="form-check-input calendar-checkbox" type="checkbox" data-owned="1" value="${cal.id}" id="cal${cal.id}" checked>` +
          `<label class="form-check-label fs-5" for="cal${cal.id}">${cal.name}</label>`;
        sidebar.appendChild(div);
      });
    }
    if (otherCals.length) {
      const hOther = document.createElement('h6');
      hOther.textContent = 'Others Calendars';
      sidebar.appendChild(hOther);
      otherCals.forEach(cal => {
        const div = document.createElement('div');
        div.className = 'form-check form-check-lg';
        div.innerHTML = `<input class="form-check-input calendar-checkbox" type="checkbox" value="${cal.id}" id="cal${cal.id}" checked>` +
          `<label class="form-check-label fs-5" for="cal${cal.id}">${cal.name}</label>`;
        sidebar.appendChild(div);
      });
    }
    function ensureSelected() {
      const personalChecked = sidebar.querySelectorAll('.calendar-checkbox[data-owned="1"]:checked');
      if (!personalChecked.length) {
        const firstPersonal = sidebar.querySelector('.calendar-checkbox[data-owned="1"]');
        if (firstPersonal) firstPersonal.checked = true;
      }
      const anyChecked = sidebar.querySelectorAll('.calendar-checkbox:checked');
      if (!anyChecked.length) {
        const publicCb = document.getElementById(`cal${userPublicCalendarId}`);
        if (publicCb) publicCb.checked = true;
      }
    }
    sidebar.querySelectorAll('.calendar-checkbox').forEach(cb => {
      cb.addEventListener('change', () => {
        ensureSelected();
        calendar.refetchEvents();
        if (addEventForm) {
          selectCalendarRadio(addEventForm, getCalendarId());
        }
      });
    });
    ensureSelected();
    if (addEventForm) {
      selectCalendarRadio(addEventForm, getCalendarId());
    }
    calendar.render();
    calendar.refetchEvents();
  }


  initSidebar();

  window.addEventListener('message', function(e) {
    if (e.data === 'calendarLinked') {
      window.location.reload();
    }
  });

  if (addEventModalEl && addEventForm) {
    addEventModalEl.addEventListener('show.bs.modal', function() {
      selectCalendarRadio(addEventForm, getCalendarId());
    });
  }

  if (addEventForm) {
    addEventForm.addEventListener('change', function(e) {
      if (e.target.name === 'calendar_id_radio') {
        this.calendar_id.value = e.target.value;

      }
    });

    addEventForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const cid = parseInt(getCalendarId(), 10);
      if (!ownedCalendarIds.includes(cid)) {
        alert('Please select one of your calendars before adding an event.');
        return;
      }
      this.calendar_id.value = cid;
      const fd = new FormData(this);
      fd.append('visibility_id', this.is_private.checked ? VISIBILITY_PRIVATE : VISIBILITY_PUBLIC);
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
  }

  document.getElementById('openAddEvent').addEventListener('click', () => { selectCalendarRadio(addEventForm, getCalendarId()); bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show(); });

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

  window.deleteCalendar = function(id) {
    const fd = new FormData();
    fd.append('id', id);
    fetch('<?php echo getURLDir(); ?>module/calendar/functions/delete_calendar.php', {
      method: 'POST',
      body: fd
    })
    .then(r => {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(data => {
      if (data.success) {
        calendar.refetchEvents();
      } else {
        alert(data.error || 'Unable to delete calendar.');
      }
    })
    .catch(err => {
      console.error('Failed to delete calendar', err);
      alert('Failed to delete calendar: ' + err.message);
    });
  };
});
</script>
