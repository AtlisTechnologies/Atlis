<?php
$isEdit = !empty($meeting);
// Lookup items for agenda statuses
$agendaStatusMap   = array_column(get_lookup_items($pdo, 'MEETING_AGENDA_STATUS'), null, 'id');
// Lookup items for question statuses
$questionStatusMap = array_column(get_lookup_items($pdo, 'MEETING_QUESTION_STATUS'), null, 'id');
// Lookup items for meeting status and type
$meetingStatusList = get_lookup_items($pdo, 'MEETING_STATUS');
$meetingTypeList   = get_lookup_items($pdo, 'MEETING_TYPE');
$token = generate_csrf_token();
?>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>
<div class="container-fluid py-4">
  <h2 class="mb-4"><?php echo $isEdit ? 'Edit Meeting' : 'Create Meeting'; ?></h2>
  <form id="meetingForm" method="post" enctype="multipart/form-data" action="functions/<?php echo $isEdit ? 'update.php' : 'create.php'; ?>">
    <input type="hidden" name="csrf_token" value="<?php echo h($token); ?>">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?php echo (int)$meeting['id']; ?>">
    <?php endif; ?>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label" for="title">Title</label>
        <input type="text" id="title" name="title" class="form-control" placeholder="Meeting title" value="<?php echo h($meeting['title'] ?? ''); ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="start_time">Start Time</label>
        <input type="datetime-local" id="start_time" name="start_time" class="form-control" placeholder="Start time" value="<?php echo !empty($meeting['start_time']) ? h(date('Y-m-d\\TH:i', strtotime($meeting['start_time']))) : ''; ?>" required>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label" for="end_time">End Time</label>
        <input type="datetime-local" id="end_time" name="end_time" class="form-control" placeholder="End time" value="<?php echo !empty($meeting['end_time']) ? h(date('Y-m-d\\TH:i', strtotime($meeting['end_time']))) : ''; ?>">
      </div>
      <div class="col-md-6">
        <label class="form-label" for="description">Description</label>
        <textarea id="description" name="description" class="form-control" placeholder="Meeting description" rows="1"><?php echo h($meeting['description'] ?? ''); ?></textarea>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label" for="status_id">Status</label>
        <select id="status_id" name="status_id" class="form-select">
          <option value="">Select status</option>
          <?php foreach ($meetingStatusList as $s): ?>
            <option value="<?= (int)$s['id']; ?>" <?php echo (isset($meeting['status_id']) && (int)$meeting['status_id'] === (int)$s['id']) ? 'selected' : ''; ?>><?= h($s['label']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="type_id">Type</label>
        <select id="type_id" name="type_id" class="form-select">
          <option value="">Select type</option>
          <?php foreach ($meetingTypeList as $t): ?>
            <option value="<?= (int)$t['id']; ?>" <?php echo (isset($meeting['type_id']) && (int)$meeting['type_id'] === (int)$t['id']) ? 'selected' : ''; ?>><?= h($t['label']); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label" for="calendar_event_search">Event</label>
        <input type="text" id="calendar_event_search" class="form-control" placeholder="Search event">
        <input type="hidden" name="calendar_event_id" id="calendar_event_id" value="<?php echo h($meeting['calendar_event_id'] ?? ''); ?>">
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Recurrence</label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="recur_daily" name="recur_daily" value="1" <?php echo !empty($meeting['recur_daily']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="recur_daily">Daily</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="recur_weekly" name="recur_weekly" value="1" <?php echo !empty($meeting['recur_weekly']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="recur_weekly">Weekly</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" id="recur_monthly" name="recur_monthly" value="1" <?php echo !empty($meeting['recur_monthly']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="recur_monthly">Monthly</label>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Agenda</label>
      <ul id="agendaList" class="list-group"></ul>
      <button type="button" class="btn btn-sm btn-primary mt-2" id="addAgendaItem">Add Agenda Item</button>
    </div>
    <div class="mb-3">
      <label class="form-label">Questions</label>
      <div id="questionsContainer"></div>
      <button type="button" class="btn btn-sm btn-secondary mt-2" id="addQuestion">Add Question</button>
    </div>
    <div class="mb-3">
      <label class="form-label">Attendees</label>
      <div id="attendeesContainer"></div>
      <button type="button" class="btn btn-sm btn-secondary mt-2" id="addAttendee">Add Attendee</button>
    </div>
    <div class="mb-3">
      <label class="form-label">Upload Files</label>
      <input type="file" name="files[]" id="meetingFiles" multiple class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
  </form>
</div>
<script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var isEdit = <?php echo $isEdit ? 'true' : 'false'; ?>;
  var csrfToken = '<?php echo h($token); ?>';
  var agendaStatusMap   = <?php echo json_encode($agendaStatusMap); ?>;
  var questionStatusMap = <?php echo json_encode($questionStatusMap); ?>;
  var agendaList = document.getElementById('agendaList');
  var attendeesContainer = document.getElementById('attendeesContainer');
  var eventSearchInput = document.getElementById('calendar_event_search');
  var eventIdInput = document.getElementById('calendar_event_id');
  if(eventSearchInput && eventIdInput){
    initTypeahead(eventSearchInput, eventIdInput, 'functions/search_events.php');
  }


  function showToast(msg, type = 'danger'){
    var container = document.getElementById('toastContainer');
    if(!container){ alert(msg); return; }
    var toastEl = document.createElement('div');
    toastEl.className = 'toast align-items-center text-bg-' + type + ' border-0';
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = '<div class="d-flex"><div class="toast-body">'+esc(msg)+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
    container.appendChild(toastEl);
    new bootstrap.Toast(toastEl).show();
  }

  new Sortable(agendaList, {handle: '.drag-handle', animation:150});

  function esc(str){
    return str ? str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;') : '';
  }

  function initTypeahead(textInput, hiddenInput, endpoint){
    var list = document.createElement('datalist');
    list.id = 'dl_' + Math.random().toString(36).slice(2);
    document.body.appendChild(list);
    textInput.setAttribute('list', list.id);
    function renderOptions(items){
      list.innerHTML = '';
      items.forEach(function(item){
        var opt = document.createElement('option');
        var label = item.title || item.name || '';
        opt.value = label;
        opt.dataset.id = item.id;
        list.appendChild(opt);
      });
    }
    textInput.addEventListener('input', function(){
      var url = endpoint + '?q=' + encodeURIComponent(this.value);
      fetch(url)
        .then(r => r.ok ? r.json() : Promise.reject(new Error('Search failed')))
        .then(renderOptions)
        .catch(err => {
          list.innerHTML = '<option value="">Error</option>';
          console.error('Search failed', err);
        });
    });
    textInput.addEventListener('change', function(){
      hiddenInput.value = '';
      Array.from(list.options).forEach(function(opt){
        if(opt.value === textInput.value){ hiddenInput.value = opt.dataset.id || ''; }
      });
      if(hiddenInput.value === ''){ textInput.value = ''; }
    });
  }

  function initAgendaItem(li, data){
    var statusSelect = li.querySelector('select[name="agenda_status_id[]"]');
    var options = '<option value="">Select status</option>';
    for (var id in agendaStatusMap){
      if(Object.prototype.hasOwnProperty.call(agendaStatusMap, id)){
        options += '<option value="' + id + '">' + esc(agendaStatusMap[id].label) + '</option>';
      }
    }
    statusSelect.innerHTML = options;
    li.querySelector('input[name="agenda_title[]"]').value = data && data.title ? data.title : '';
    statusSelect.value = data && data.status_id ? data.status_id : '';
    li.querySelector('input[name="agenda_order_index[]"]').value = data && data.order_index ? data.order_index : '';
    li.querySelector('input[name="agenda_linked_task_id[]"]').value = data && data.linked_task_id ? data.linked_task_id : '';
    li.querySelector('input[name="agenda_linked_project_id[]"]').value = data && data.linked_project_id ? data.linked_project_id : '';

    initTypeahead(li.querySelector('.task-search'), li.querySelector('input[name="agenda_linked_task_id[]"]'), 'functions/search_tasks.php');
    initTypeahead(li.querySelector('.project-search'), li.querySelector('input[name="agenda_linked_project_id[]"]'), 'functions/search_projects.php');
  }

  function addAgendaItem(data){
    fetch('include/agenda_item.php').then(r=>r.text()).then(function(html){
      var temp = document.createElement('div');
      temp.innerHTML = html.trim();
      var li = temp.firstChild;
      agendaList.appendChild(li);
      initAgendaItem(li, data || {});
    });
  }

  document.getElementById('addAgendaItem').addEventListener('click', function(){ addAgendaItem(); });

  agendaList.addEventListener('click', function(e){
    if(e.target.closest('.remove-agenda-item')){
      e.target.closest('li').remove();
    }
  });

  document.getElementById('meetingForm').addEventListener('submit', function(e){
    e.preventDefault();
    Array.from(agendaList.querySelectorAll('li')).forEach(function(li, idx){
      var orderInput = li.querySelector('input[name="agenda_order_index[]"]');
      if(orderInput){ orderInput.value = idx + 1; }
    });
    var fd = new FormData(this);
    fetch(this.action, {method:'POST', body: fd})
      .then(r => r.json())
      .then(function(res){
        if(res.success && res.id){
          window.location = 'index.php?action=details&id=' + res.id;
        } else {
          var msg = res.message || (res.errors ? res.errors.join(', ') : 'Failed to save meeting');
          showToast(msg);
        }
      })
      .catch(function(err){
        console.error(err);
        showToast('Failed to save meeting');
      });
  });

  function initAttendeeRow(div, data){
    var searchInput = div.querySelector('.attendee-search');
    var idInput = div.querySelector('input[name="attendee_user_id[]"]');
    initTypeahead(searchInput, idInput, 'functions/search_users.php');
    if(data){
      searchInput.value = data.name || '';
      idInput.value = data.attendee_user_id || '';
    }
  }

  function addAttendee(data){
    var row = document.createElement('div');
    row.className = 'row g-2 mb-2 attendee-item';
    row.innerHTML = '<div class="col-md-10"><input type="text" class="form-control attendee-search" placeholder="Search user"><input type="hidden" name="attendee_user_id[]"></div>' +
      '<div class="col-md-2"><button type="button" class="btn btn-sm btn-danger remove-attendee">Remove</button></div>';
    attendeesContainer.appendChild(row);
    initAttendeeRow(row, data || {});
  }

  document.getElementById('addAttendee').addEventListener('click', function(){ addAttendee(); });

  attendeesContainer.addEventListener('click', function(e){
    if(e.target.closest('.remove-attendee')){
      e.target.closest('.attendee-item').remove();
    }
  });

  function addQuestion(data){
    var div = document.createElement('div');
    div.className = 'border rounded p-3 mb-2';
    var statusOptions = '<option value="">Select status</option>';
    for (var id in questionStatusMap){
      if(Object.prototype.hasOwnProperty.call(questionStatusMap, id)){
        statusOptions += '<option value="' + id + '">' + esc(questionStatusMap[id].label) + '</option>';
      }
    }
    div.innerHTML = '<input type="text" name="question_text[]" class="form-control mb-2" placeholder="Question" required>' +
      '<textarea name="answer_text[]" class="form-control mb-2" placeholder="Answer"></textarea>' +
      '<select name="question_status_id[]" class="form-select mb-2">' + statusOptions + '</select>' +
      '<input type="number" name="agenda_id[]" class="form-control mb-2" placeholder="Agenda ID (optional)">';
    if(data){
      div.querySelector('input[name="question_text[]"]').value = data.question_text || '';
      div.querySelector('textarea[name="answer_text[]"]').value = data.answer_text || '';
      div.querySelector('select[name="question_status_id[]"]').value = data.status_id || '';
      div.querySelector('input[name="agenda_id[]"]').value = data.agenda_id || '';
    }
    document.getElementById('questionsContainer').appendChild(div);
  }

  document.getElementById('addQuestion').addEventListener('click', function(){ addQuestion(); });

  if(isEdit){
    fetch('functions/get_agenda.php?meeting_id=<?php echo $isEdit ? (int)$meeting['id'] : 0; ?>&csrf_token=' + encodeURIComponent(csrfToken))
      .then(r=>r.json()).then(function(res){
      if(res.items){ res.items.forEach(function(item){ addAgendaItem(item); }); }
    });
    fetch('functions/get_questions.php?meeting_id=<?php echo $isEdit ? (int)$meeting['id'] : 0; ?>&csrf_token=' + encodeURIComponent(csrfToken))
      .then(r=>r.json()).then(function(res){
      if(res.questions){ res.questions.forEach(function(q){ addQuestion(q); }); }
    });
    fetch('functions/get_attendees.php?meeting_id=<?php echo $isEdit ? (int)$meeting['id'] : 0; ?>&csrf_token=' + encodeURIComponent(csrfToken))
      .then(r=>r.json())
      .then(function(res){
        if(res.success && res.attendees){ res.attendees.forEach(function(a){ addAttendee(a); }); }
      });
  }
});
</script>

