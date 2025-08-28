<?php
$calendars = [];
$sql = 'SELECT id, name, is_private, is_default, user_id = :uid AS owned, CASE WHEN user_id = :uid THEN ics_token ELSE NULL END AS ics_token FROM module_calendar WHERE user_id = :uid OR is_private = 0 ORDER BY owned DESC, name';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uid', $this_user_id, PDO::PARAM_INT);
$stmt->execute();
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($calendars as &$cal) {
    if (!empty($cal['owned']) && empty($cal['ics_token'])) {
        $token = bin2hex(random_bytes(16));
        $upd = $pdo->prepare('UPDATE module_calendar SET ics_token = ? WHERE id = ?');
        $upd->execute([$token, $cal['id']]);
        $cal['ics_token'] = $token;
    }
}
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


$user_default_event_type_id = get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_EVENT_TYPE') ?? 0;
//$default_event_type_id = $user_default_event_type_id ?: ($event_types[0]['id'] ?? 0);
$default_event_type_id = get_user_default_lookup_item($pdo, $this_user_id, 'CALENDAR_EVENT_TYPE_DEFAULT') ?? 0;


?>

<link rel="stylesheet" href="<?php echo getURLDir(); ?>assets/css/theme.css">
<link rel="stylesheet" href="<?php echo getURLDir(); ?>assets/css/calendar-override.css">

<div class="row g-0">
  <div class="col-lg-2 col-md-3 px-0">
    <?php if (user_has_permission('calendar','create')): ?>
      <div class="mb-3 text-center">
        <button class="btn btn-atlis w-100" type="button" data-bs-toggle="modal" data-bs-target="#createCalendarModal">Create Calendar</button>
      </div>
    <?php endif; ?>
    <div id="calendarSidebar"></div>
  </div>
  <div class="col px-3">
    <div id="calendarAlert"></div>
    <div id="calendarSpinner" class="spinner-border text-primary" role="status" style="display:none;">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="row g-0 mb-4 align-items-center">
      <div class="col-5 col-md-6">
        <h4 class="mb-0 text-body-emphasis fw-bold fs-md-6"><span class="calendar-day d-block d-md-inline mb-1"></span><span class="px-3 fw-thin text-body-quaternary d-none d-md-inline">|</span><span class="calendar-date"></span></h4>
      </div>
      <div class="col-7 col-md-6 d-flex justify-content-end">
        <button id="addEventButton" class="btn btn-primary btn-sm" type="button"><span class="fas fa-plus pe-2 fs-10"></span>Add Event</button>
      </div>
    </div>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-y border-translucent">
      <div class="row py-3 gy-3 gx-0">
        <div class="col-6 col-md-4 order-1 d-flex align-items-center">
          <button class="btn btn-sm btn-phoenix-primary px-4" data-event="today">Today</button>
        </div>
        <div class="col-12 col-md-4 order-md-1 d-flex align-items-center justify-content-center">
          <button class="btn icon-item icon-item-sm shadow-none text-body-emphasis p-0" type="button" data-event="prev" title="Previous"><span class="fas fa-chevron-left"></span></button>
          <h3 class="px-3 text-body-emphasis fw-semibold calendar-title mb-0"> </h3>
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
  </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="addEventForm" autocomplete="off">

        <input type="hidden" name="calendar_id" id="addEventCalendar" value="<?= (int)$default_add_calendar_id; ?>" />

        <div class="modal-header px-card border-0">
          <h5 class="mb-0 lh-sm text-body-highlight">Add Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
          <div class="form-floating mb-3">
            <select class="form-select" id="addEventType" name="event_type_id">
              <option value="" <?= $default_event_type_id ? '' : 'selected'; ?>>Select type</option>
              <?php foreach ($event_types as $et): ?>
                <option value="<?= (int)$et['id']; ?>" class="text-<?= h($et['color_class']); ?>" data-icon="<?= h($et['icon_class']); ?>"<?= (int)$et['id'] === (int)$default_event_type_id ? ' selected' : ''; ?>><?= h($et['label']); ?></option>
              <?php endforeach; ?>
            </select>
            <label for="addEventType">Event Type</label>
          </div>

          <?php if ($owns_calendar) { ?>
            <div class="mb-3">
              <label class="form-label d-block mb-2">Calendar</label>
              <?php foreach ($calendars as $cal): ?>
                <?php if (!empty($cal['owned'])): ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="calendar_id_radio" id="addEventCal-<?= (int)$cal['id']; ?>" value="<?= (int)$cal['id']; ?>"<?= (int)$cal['id'] === (int)$default_add_calendar_id ? ' checked' : ''; ?>>
                    <label class="form-check-label" for="addEventCal-<?= (int)$cal['id']; ?>"><?= e($cal['name']); ?></label>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          <?php } ?>
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
          <div class="form-floating mb-3">
            <select class="form-select" id="editEventType" name="event_type_id">
              <option value="">Select type</option>
              <?php foreach ($event_types as $et): ?>
                <option value="<?= (int)$et['id']; ?>" class="text-<?= h($et['color_class']); ?>" data-icon="<?= h($et['icon_class']); ?>"<?= (int)$et['id'] === (int)$default_event_type_id ? ' selected' : ''; ?>><?= h($et['label']); ?></option>
              <?php endforeach; ?>
            </select>
            <label for="editEventType">Event Type</label>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center border-0">
          <button class="btn btn-primary px-4" type="submit">Update</button>
        </div>
      </form>
  </div>
</div>
</div>

<div class="modal fade" id="createCalendarModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <form id="createCalendarForm" autocomplete="off">
        <div class="modal-header px-card border-0">
          <h5 class="mb-0 lh-sm text-body-highlight">Create Calendar</h5>
          <button class="btn p-1 fs-10 text-body" type="button" data-bs-dismiss="modal" aria-label="Close">CLOSE</button>
        </div>
        <div class="modal-body p-card py-0">
          <div class="form-floating mb-3">
            <input class="form-control" id="calendarName" type="text" name="name" placeholder="Calendar Name" required />
            <label for="calendarName">Name</label>
          </div>
          <div class="form-check mb-3 fs-7">
            <input class="form-check-input" type="checkbox" id="calendarPrivate" name="is_private" value="1">
            <label class="form-check-label" for="calendarPrivate">Private</label>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-end align-items-center border-0">
          <button class="btn btn-primary px-4" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="eventDetailsModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border border-translucent"></div>
  </div>
</div>

<div class="modal fade" id="calendarSettingsModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border border-translucent">
      <div class="modal-header px-card border-0">
        <h5 class="mb-0 lh-sm text-body-highlight">Calendar Settings</h5>
        <button class="btn p-1 fs-10 text-body" type="button" data-bs-dismiss="modal" aria-label="Close">CLOSE</button>
      </div>
      <div class="modal-body p-card py-0">
        <div class="mb-3">
          <label class="form-label" for="calendarFeedUrl">iCal Feed URL</label>
          <input type="text" class="form-control" id="calendarFeedUrl" readonly>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" id="calendarToast"></div>

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
  const calendarEl = document.getElementById('appCalendar');
  const addEventForm = document.getElementById('addEventForm');
  const addEventModalEl = document.getElementById('addEventModal');
  const addEventButton = document.getElementById('addEventButton');
  const listUrl = '<?php echo getURLDir(); ?>module/calendar/functions/list.php';
  const feedUrlBase = '<?php echo getURLDir(); ?>module/calendar/functions/ics_feed.php';
  const calendarSpinner = document.getElementById('calendarSpinner');
  const alertPlaceholder = document.getElementById('calendarAlert');
  const calendarsData = <?php echo json_encode($calendars); ?>;
  const currentUserId = <?= (int)$this_user_id ?>;
  const isAdmin = <?= user_has_role('Admin') ? 'true' : 'false' ?>;
  const eventTypes = <?php echo json_encode($event_types); ?>;
  const eventTypeMap = {};
  eventTypes.forEach(et => { eventTypeMap[et.id] = et.label; });
  const createCalendarForm = document.getElementById('createCalendarForm');
  const createCalendarModalEl = document.getElementById('createCalendarModal');
  const detailModalEl = document.getElementById('eventDetailsModal');
  const eventStartInput = document.getElementById('eventStart');
  const eventEndInput = document.getElementById('eventEnd');
  if (eventStartInput && eventEndInput) {
    eventStartInput.addEventListener('change', function() {
      if (this.value) {
        eventEndInput.value = dayjs(this.value).add(1, 'hour').format('YYYY-MM-DD HH:mm');
      }
    });
  }

  function showAlert(message, type = 'danger') {
    if (!alertPlaceholder) return;
    alertPlaceholder.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}` +
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
  }

  function showToast(message, type = 'primary') {
    const container = document.getElementById('calendarToast');
    if (!container) return;
    const el = document.createElement('div');
    el.className = `toast align-items-center text-white dark__text-gray-1100 bg-${type} border-0`;
    el.role = 'alert';
    el.ariaLive = 'assertive';
    el.ariaAtomic = 'true';
    el.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div>` +
      '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
    container.appendChild(el);
    const toast = new bootstrap.Toast(el);
    toast.show();
    el.addEventListener('hidden.bs.toast', () => el.remove());
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

  function openAddEvent() {
    const cid = parseInt(getCalendarId(), 10);
    if (!ownedCalendarIds.includes(cid)) {
      showToast('Create a calendar to add events');
      return;
    }
    selectCalendarRadio(addEventForm, cid);
    addEventForm.event_type_id.value = defaultEventTypeId || '';
    bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show();
  }

  if (addEventButton) {
    addEventButton.addEventListener('click', openAddEvent);
  }

  const calendar = new FullCalendar.Calendar(calendarEl, {
    headerToolbar: false,
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
      if (!detailModalEl) return;
      const relatedModule = info.event.extendedProps.related_module || info.event.extendedProps.link_module;
      const relatedId = info.event.extendedProps.related_id || info.event.extendedProps.link_record_id;
      const link = (relatedModule && relatedId) ? `/module/${relatedModule}/index.php?action=view&id=${relatedId}` : '';
      const eventOwnerId = parseInt(info.event.extendedProps.user_id, 10);
      const calOwnerId = parseInt(info.event.extendedProps.calendar_user_id, 10);
      const displayOwner = eventOwnerId || calOwnerId || '';
      const canEdit = (eventOwnerId === currentUserId) || (calOwnerId === currentUserId) || isAdmin;
      const footer = canEdit ? `<div class="modal-footer d-flex justify-content-end border-0"><button class="btn btn-primary px-4" type="button" id="detailEditBtn">Edit</button></div>` : '';
      const body = `
        <div class="modal-header ps-card border-bottom border-translucent justify-content-between">
          <div><h4 class="modal-title text-body-highlight mb-0">${info.event.title || ''}</h4></div>
          <button type="button" class="btn p-1 fw-bolder" data-bs-dismiss="modal" aria-label="Close"><span class='fas fa-times fs-8'></span></button>
        </div>
        <div class="modal-body p-card py-0">
          <div class="mb-3"><strong>Starts at:</strong> ${dayjs(info.event.start).format('YYYY-MM-DD HH:mm')}</div>
          <div class="mb-3"><strong>Ends at:</strong> ${info.event.end ? dayjs(info.event.end).format('YYYY-MM-DD HH:mm') : ''}</div>
          <div class="mb-3"><strong>Event Type:</strong> ${eventTypeMap[info.event.extendedProps.event_type_id] || ''}</div>
          <div class="mb-3"><strong>Description:</strong> ${info.event.extendedProps.description || info.event.extendedProps.memo || ''}</div>
          <div class="mb-3"><strong>Related Module:</strong> ${relatedModule || ''}</div>
          <div class="mb-3"><strong>Related ID:</strong> ${relatedId || ''}</div>
          <div class="mb-3"><strong>Owner:</strong> ${displayOwner}</div>
          ${link ? `<div class="mb-3"><a href="${link}" target="_blank">View Record</a></div>` : ''}
        </div>
        ${footer}`;
      detailModalEl.querySelector('.modal-content').innerHTML = body;
      const modal = bootstrap.Modal.getOrCreateInstance(detailModalEl);
      modal.show();
      if (canEdit) {
        detailModalEl.querySelector('#detailEditBtn').addEventListener('click', function() {
          const form = document.getElementById('editEventForm');
          form.id.value = info.event.id;
          form.title.value = info.event.title;
          form.start_time.value = dayjs(info.event.start).format('YYYY-MM-DD HH:mm');
          form.end_time.value = info.event.end ? dayjs(info.event.end).format('YYYY-MM-DD HH:mm') : '';
          form.event_type_id.value = info.event.extendedProps.event_type_id || defaultEventTypeId || '';
          selectCalendarRadio(form, info.event.extendedProps.calendar_id || getCalendarId());
          modal.hide();
          bootstrap.Modal.getOrCreateInstance(document.getElementById('editEventModal')).show();
        });
      }
    },
    dateClick: function(info) {
      const form = addEventForm;
      form.start_time.value = dayjs(info.date).format('YYYY-MM-DD HH:mm');
      form.end_time.value = '';
      form.event_type_id.value = defaultEventTypeId || '';
      selectCalendarRadio(form, getCalendarId());
      bootstrap.Modal.getOrCreateInstance(document.getElementById('addEventModal')).show();
    }
    });

  const prevBtn = document.querySelector('[data-event="prev"]');
  const nextBtn = document.querySelector('[data-event="next"]');
  const todayBtn = document.querySelector('[data-event="today"]');
  const viewBtns = document.querySelectorAll('[data-fc-view]');
  const titleEl = document.querySelector('.calendar-title');
  if (prevBtn) prevBtn.addEventListener('click', () => calendar.prev());
  if (nextBtn) nextBtn.addEventListener('click', () => calendar.next());
  if (todayBtn) todayBtn.addEventListener('click', () => calendar.today());
  if (viewBtns.length) {
    viewBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        calendar.changeView(this.dataset.fcView);
        viewBtns.forEach(b => b.classList.remove('active-view'));
        this.classList.add('active-view');
      });
    });
  }
  calendar.on('datesSet', function(info) {
    if (titleEl) titleEl.textContent = info.view.title;
  });

  let calendarRendered = false;
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
        div.className = 'fs-7 d-flex align-items-center gap-2';
        div.innerHTML = `<input class="form-check-input calendar-checkbox" type="checkbox" data-owned="1" value="${cal.id}" id="cal${cal.id}" checked>` +
          `<label for="cal${cal.id}" class="mb-0 flex-grow-1">${cal.name}</label>`;
        sidebar.appendChild(div);
      });
    }
    if (otherCals.length) {
      const hOther = document.createElement('h6');
      hOther.textContent = 'Others Calendars';
      sidebar.appendChild(hOther);
      otherCals.forEach(cal => {
        const div = document.createElement('div');
        div.className = 'fs-7 d-flex align-items-center gap-2';
        div.innerHTML = `<input class="form-check-input calendar-checkbox" type="checkbox" value="${cal.id}" id="cal${cal.id}" checked>` +
          `<label for="cal${cal.id}" class="mb-0">${cal.name}</label>`;
        sidebar.appendChild(div);
      });
    }
    function ensureSelected(changed) {
      if (!sidebar.querySelector('.calendar-checkbox:checked')) {
        changed.checked = true;
      }
    }
    sidebar.querySelectorAll('.calendar-checkbox').forEach(cb => {
      cb.addEventListener('change', () => {
        ensureSelected(cb);
        calendar.refetchEvents();
        if (addEventForm) {
          selectCalendarRadio(addEventForm, getCalendarId());
        }
      });
    });
    ensureSelected(sidebar.querySelector('.calendar-checkbox'));
    if (addEventForm) {
      selectCalendarRadio(addEventForm, getCalendarId());
    }
    if (!calendarRendered) {
      calendar.render();
      calendarRendered = true;
    }
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
      addEventForm.event_type_id.value = defaultEventTypeId || '';
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
        showToast('Please select one of your calendars before adding an event.', 'danger');
        return;
      }
      this.calendar_id.value = cid;
      const fd = new FormData(this);
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
          showToast('Event created');
          calendar.refetchEvents();
        } else {
          showToast(data.error || 'An error occurred while adding the event.', 'danger');
        }
      })
      .catch(err => {
        console.error('Failed to add event', err);
        showToast('Failed to add event: ' + err.message, 'danger');
      });
    });
  }

  document.getElementById('editEventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    this.calendar_id.value = getCalendarId();
    const fd = new FormData(this);
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
        showToast(data.error || 'An error occurred while updating the event.', 'danger');
      }
    })
    .catch(err => {
      console.error('Failed to update event', err);
      showToast('Failed to update event: ' + err.message, 'danger');
    });
  });

  if (createCalendarForm) {
    createCalendarForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const fd = new FormData(this);
      fetch('<?php echo getURLDir(); ?>module/calendar/functions/create_calendar.php', {
        method: 'POST',
        body: fd
      })
      .then(r => {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
      })
      .then(data => {
        if (data.success) {
          bootstrap.Modal.getInstance(createCalendarModalEl).hide();
          this.reset();
          fetch('<?php echo getURLDir(); ?>module/calendar/functions/list_calendars.php')
            .then(r => r.json())
            .then(cals => {
              calendarsData.length = 0;
              cals.forEach(c => calendarsData.push(c));
              ownedCalendarIds.length = 0;
              cals.filter(c => parseInt(c.owned, 10)).forEach(c => ownedCalendarIds.push(parseInt(c.id, 10)));
              initSidebar();
              calendar.refetchEvents();
              showToast('Calendar created');
            });
        } else {
          alert(data.error || 'Error creating calendar');
        }
      })
      .catch(err => {
        console.error('Failed to create calendar', err);
        alert('Failed to create calendar: ' + err.message);
      });
    });
  }

  window.openCalSettings = function(id) {
    const cal = calendarsData.find(c => parseInt(c.id, 10) === parseInt(id, 10));
    if (!cal || parseInt(cal.owned, 10) !== 1) { return; }
    const url = `${feedUrlBase}?calendar_id=${cal.id}&ics_token=${cal.ics_token}`;
    const input = document.getElementById('calendarFeedUrl');
    if (input) { input.value = url; }
    bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarSettingsModal')).show();
  };

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
