<?php
$agendaStatusMap  = array_column(get_lookup_items($pdo, 'MEETING_AGENDA_STATUS'), null, 'id');
$meetingStatusMap = array_column(get_lookup_items($pdo, 'MEETING_STATUS'), null, 'id');
$meetingTypeMap   = array_column(get_lookup_items($pdo, 'MEETING_TYPE'), null, 'id');
$meetingStatusLabel = !empty($meeting['status_id']) && isset($meetingStatusMap[$meeting['status_id']]) ? $meetingStatusMap[$meeting['status_id']]['label'] : null;
$meetingTypeLabel   = !empty($meeting['type_id']) && isset($meetingTypeMap[$meeting['type_id']]) ? $meetingTypeMap[$meeting['type_id']]['label'] : null;
$token = $_SESSION['csrf_token'] ?? bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
?>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>
<div class="container-fluid py-4">
  <div class="row mb-3">
    <div class="col">
      <h2><?php echo h($meeting['title'] ?? 'Meeting'); ?>
        <?php if ($meetingStatusLabel): ?>
          <span class="badge bg-secondary ms-2"><?php echo h($meetingStatusLabel); ?></span>
        <?php endif; ?>
        <?php if ($meetingTypeLabel): ?>
          <span class="badge bg-secondary ms-1"><?php echo h($meetingTypeLabel); ?></span>
        <?php endif; ?>
      </h2>
      <?php if (!empty($meeting['description'])): ?>
      <p class="text-body-secondary mb-1"><?php echo h($meeting['description']); ?></p>
      <?php endif; ?>
      <p class="mb-0"><strong>Start:</strong> <?php echo !empty($meeting['start_time']) ? h(date('l, F j, Y g:i A', strtotime($meeting['start_time']))) : ''; ?></p>
      <?php if (!empty($meeting['end_time'])): ?>
      <p class="mb-0"><strong>End:</strong> <?php echo h(date('l, F j, Y g:i A', strtotime($meeting['end_time']))); ?></p>
      <?php endif; ?>
      <p class="mb-0"><strong>Recurs:</strong> <?php
        $recur = [];
        if (!empty($meeting['recur_daily'])) $recur[] = 'Daily';
        if (!empty($meeting['recur_weekly'])) $recur[] = 'Weekly';
        if (!empty($meeting['recur_monthly'])) $recur[] = 'Monthly';
        echo $recur ? h(implode(', ', $recur)) : 'No';
      ?></p>
      <?php if (user_has_permission('meeting','create')): ?>
      <div class="mt-3">
        <button class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#taskModal">Create Task</button>
        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#projectModal">Create Project</button>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">Agenda</div>
        <div class="card-body p-0">
          <ul class="list-group list-group-flush" id="agendaList"></ul>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
          <span>Questions</span>
          <?php if (user_has_permission('meeting','update')): ?>
            <button class="btn btn-sm btn-primary" id="addQuestionBtn">Add Question</button>
          <?php endif; ?>
        </div>
        <div class="card-body" id="questionsList"></div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card mb-3">
        <div class="card-header">Attendees</div>
        <div class="card-body p-0">
          <?php if (user_has_permission('meeting','update')): ?>
          <form id="attendeeForm" class="row g-2 align-items-end p-3 border-bottom">
            <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
            <div class="col-md-4 position-relative">
              <input type="text" id="attendeeSearch" class="form-control" placeholder="Search user">
              <input type="hidden" name="attendee_user_id" id="attendeeId">
              <div class="list-group position-absolute w-100" id="attendeeResults" style="z-index:1000;"></div>
            </div>
            <div class="col-md-2">
              <input type="text" name="role" class="form-control" placeholder="Role">
            </div>
            <div class="col-md-3">
              <input type="datetime-local" name="check_in_time" class="form-control">
            </div>
            <div class="col-md-3">
              <input type="datetime-local" name="check_out_time" class="form-control">
            </div>
            <div class="col-12">
              <button type="submit" class="btn btn-sm btn-primary mt-2">Add</button>
            </div>
          </form>
          <?php endif; ?>
          <ul class="list-group list-group-flush" id="attendeesList"></ul>
        </div>
      </div>
      <div class="card mb-3">
        <div class="card-header">Attachments</div>
        <div class="card-body">
          <?php if (user_has_permission('meeting','update')): ?>
          <form id="uploadForm" class="mb-3">
            <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
            <input type="hidden" name="csrf_token" value="<?= $token; ?>">
            <input type="file" name="file[]" multiple class="form-control mb-2">
            <button class="btn btn-sm btn-primary" type="submit">Upload</button>
          </form>
          <?php endif; ?>
          <ul class="list-group list-group-flush" id="attachmentsList"></ul>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="taskForm">
      <div class="modal-header">
        <h5 class="modal-title">Create Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="projectForm">
      <div class="modal-header">
        <h5 class="modal-title">Create Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" class="form-control"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
</div>
</div>

<?php if (user_has_permission('meeting','update')): ?>
<div class="modal fade" id="agendaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="agendaForm">
      <div class="modal-header">
        <h5 class="modal-title" id="agendaModalLabel">Edit Agenda Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="agendaId">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" name="title" id="agendaTitle" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status_id" id="agendaStatus" class="form-select">
            <option value="">None</option>
            <?php foreach ($agendaStatusMap as $sid => $s): ?>
              <option value="<?= (int)$sid ?>"><?= h($s['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Task</label>
          <input type="text" id="agendaTaskSearch" class="form-control" placeholder="Search task">
          <input type="hidden" name="linked_task_id" id="agendaTaskId">
        </div>
        <div class="mb-3">
          <label class="form-label">Project</label>
          <input type="text" id="agendaProjectSearch" class="form-control" placeholder="Search project">
          <input type="hidden" name="linked_project_id" id="agendaProjectId">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="questionForm">
      <div class="modal-header">
        <h5 class="modal-title" id="questionModalLabel">Add Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="questionId">
        <div class="mb-3">
          <label class="form-label">Question</label>
          <input type="text" name="question_text" id="questionText" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Answer</label>
          <textarea name="answer_text" id="answerText" class="form-control"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Agenda Item</label>
          <select name="agenda_id" id="agendaSelect" class="form-select">
            <option value="">None</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>

<script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var meetingId = <?php echo (int)$meeting['id']; ?>;
  var baseUrl = '<?php echo getURLDir(); ?>';
  var canEdit = <?php echo user_has_permission('meeting','update') ? 'true' : 'false'; ?>;
  var canEditAttendees = <?php echo user_has_permission('meeting','update') ? 'true' : 'false'; ?>;
  var csrfToken = '<?= $token; ?>';
  var agendaStatusMap = <?php echo json_encode($agendaStatusMap); ?>;
  var agendaMap = {};
  var questionsData = [];
  var attendeesData = [];
  var agendaList = document.getElementById('agendaList');
  new Sortable(agendaList, {handle: '.drag-handle', animation:150, onEnd: updateOrder});

  function showToast(message, type = 'danger'){
    var container = document.getElementById('toastContainer');
    if(!container){
      alert(message);
      return;
    }
    var toastEl = document.createElement('div');
    toastEl.className = 'toast align-items-center text-bg-' + type + ' border-0';
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = '<div class="d-flex"><div class="toast-body">'+esc(message)+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
    container.appendChild(toastEl);
    new bootstrap.Toast(toastEl).show();
  }

  function fetchJson(url, opts){
    return fetch(url, opts)
      .then(function(r){
        if(!r.ok){
          return r.text().then(function(t){
            throw new Error(t || 'Request failed');
          });
        }
        return r.text();
      })
      .then(function(t){
        try {
          return JSON.parse(t);
        } catch(e){
          throw new Error('Invalid JSON: ' + e.message);
        }
      });
  }

  function updateOrder(){
    var items = agendaList.querySelectorAll('li[data-id]');
    items.forEach(function(li, index){
      var params = new URLSearchParams();
      params.append('id', li.dataset.id);
      params.append('meeting_id', meetingId);
      params.append('order_index', index + 1);
      params.append('csrf_token', csrfToken);
      fetch('functions/update_agenda_item.php', {method:'POST', body: params})
        .catch(function(err){ console.error(err); showToast('Failed to update agenda order'); });
    });
  }

  function updateAgendaSelect(){
    var sel = document.getElementById('agendaSelect');
    if(!sel) return;
    sel.innerHTML = '<option value="">None</option>';
    for(var id in agendaMap){
      if(Object.prototype.hasOwnProperty.call(agendaMap, id)){
        sel.innerHTML += '<option value="'+id+'">'+esc(agendaMap[id])+'</option>';
      }
    }
  }

  function renderAgenda(items){
    agendaList.innerHTML = '';
    agendaMap = {};
    if(items && items.length){
      items.forEach(function(item){
        agendaMap[item.id] = item.title;
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.dataset.id = item.id;
        li.dataset.statusId = item.status_id || '';
        li.dataset.taskId = item.linked_task_id || '';
        li.dataset.projectId = item.linked_project_id || '';
        var left = '<span><span class="drag-handle me-2 fas fa-grip-vertical"></span><span class="agenda-title">'+esc(item.title)+'</span>';
        var meta = [];
        if(item.status_id){
          var statusLabel = agendaStatusMap[item.status_id]?.label;
          if(statusLabel) meta.push('Status '+esc(statusLabel));
        }
        if(item.linked_task_id){ meta.push('<a href="'+baseUrl+'module/task/index.php?id='+item.linked_task_id+'">Task '+esc(String(item.linked_task_id))+'</a>'); }
        if(item.linked_project_id){ meta.push('<a href="'+baseUrl+'module/project/index.php?id='+item.linked_project_id+'">Project '+esc(String(item.linked_project_id))+'</a>'); }
        if(meta.length){ left += ' <small class="text-body-secondary">'+meta.join(' | ')+'</small>'; }
        left += '</span>';
        var buttons = canEdit ? '<div class="btn-group btn-group-sm"><button class="btn btn-outline-secondary edit-agenda-item">Edit</button><button class="btn btn-outline-danger delete-agenda-item">Delete</button></div>' : '';
        li.innerHTML = left + buttons
          + '<input type="hidden" name="agenda_title[]" value="'+esc(item.title)+'">'
          + '<input type="hidden" name="agenda_status_id[]" value="'+esc(String(item.status_id || ''))+'">'
          + '<input type="hidden" name="agenda_linked_task_id[]" value="'+esc(String(item.linked_task_id || ''))+'">'
          + '<input type="hidden" name="agenda_linked_project_id[]" value="'+esc(String(item.linked_project_id || ''))+'">';
        agendaList.appendChild(li);
      });
    } else {
      agendaList.innerHTML = '<li class="list-group-item">No agenda items.</li>';
    }
    updateAgendaSelect();
  }

  function fetchAgenda(){
    return fetchJson('functions/get_agenda.php?meeting_id=' + meetingId + '&csrf_token=' + csrfToken)
      .then(function(data){
        if(data.success){
          renderAgenda(data.items);
        } else {
          renderAgenda([]);
        }
      })
      .catch(function(err){ console.error(err); showToast('Failed to load agenda'); });
  }

  agendaList.addEventListener('click', function(e){
    var li = e.target.closest('li[data-id]');
    if(!li) return;
    if(e.target.closest('.delete-agenda-item')){
      var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId});
      params.append('csrf_token', csrfToken);
      fetchJson('functions/delete_agenda_item.php', {method:'POST', body: params})
        .then(function(res){ if(res.success) renderAgenda(res.items); })
        .catch(function(err){ console.error(err); showToast('Failed to delete agenda item'); });
    } else if(e.target.closest('.edit-agenda-item')){
      document.getElementById('agendaId').value = li.dataset.id;
      document.getElementById('agendaTitle').value = li.querySelector('.agenda-title').textContent;
      document.getElementById('agendaStatus').value = li.dataset.statusId || '';
      document.getElementById('agendaTaskSearch').value = li.dataset.taskId || '';
      document.getElementById('agendaTaskId').value = li.dataset.taskId || '';
      document.getElementById('agendaProjectSearch').value = li.dataset.projectId || '';
      document.getElementById('agendaProjectId').value = li.dataset.projectId || '';
      bootstrap.Modal.getOrCreateInstance(document.getElementById('agendaModal')).show();
    }
  });

  var agendaTaskSearch = document.getElementById('agendaTaskSearch');
  if(agendaTaskSearch){
    agendaTaskSearch.addEventListener('change', function(){
      document.getElementById('agendaTaskId').value = this.value;
    });
  }
  var agendaProjectSearch = document.getElementById('agendaProjectSearch');
  if(agendaProjectSearch){
    agendaProjectSearch.addEventListener('change', function(){
      document.getElementById('agendaProjectId').value = this.value;
    });
  }

  var agendaForm = document.getElementById('agendaForm');
  if(agendaForm){
    agendaForm.addEventListener('submit', function(e){
      e.preventDefault();
      var formData = new FormData(agendaForm);
      var id = formData.get('id');
      var li = agendaList.querySelector('li[data-id="'+id+'"]');
      if(li){
        formData.append('order_index', Array.from(agendaList.children).indexOf(li)+1);
      }
      fetchJson('functions/update_agenda_item.php', {method:'POST', body: formData})
        .then(function(res){
          if(res.success){
            renderAgenda(res.items);
            bootstrap.Modal.getInstance(document.getElementById('agendaModal')).hide();
          }
        })
        .catch(function(err){ console.error(err); showToast('Failed to save agenda item'); });
    });
  }

  fetchAgenda().then(fetchAttendees);

  function loadQuestions(){
    fetchJson('functions/get_questions.php?meeting_id=' + meetingId + '&csrf_token=' + csrfToken)
      .then(function(res){
        if(res.success){
          questionsData = res.questions;
          renderQuestions();
        }
      })
      .catch(function(err){ console.error(err); showToast('Failed to load questions'); });
  }

  function renderQuestions(){
    var container = document.getElementById('questionsList');
    container.innerHTML = '';
    if(questionsData.length){
      questionsData.forEach(function(q){
        var div = document.createElement('div');
        div.className = 'mb-3';
        div.dataset.id = q.id;
        var agendaHtml = '';
        if(q.agenda_id && agendaMap[q.agenda_id]){
          agendaHtml = '<p class="mb-1"><small>Agenda: ' + esc(agendaMap[q.agenda_id]) + '</small></p>';
        }
        div.innerHTML = '<div class="d-flex justify-content-between">'
          + '<div>'
          + '<p class="fw-bold mb-1">' + esc(q.question_text) + '</p>'
          + (q.answer_text ? '<p class="mb-1">' + esc(q.answer_text) + '</p>' : '')
          + agendaHtml
          + '</div>'
          + '</div>'
          + (canEdit ? '<div class="mt-2 text-end"><button class="btn btn-sm btn-warning me-1 edit-question" data-id="'+q.id+'">Edit</button><button class="btn btn-sm btn-danger delete-question" data-id="'+q.id+'">Delete</button></div>' : '');
        container.appendChild(div);
      });
    } else {
      container.innerHTML = '<p class="text-body-secondary mb-0">No questions.</p>';
    }
  }

  loadQuestions();

  if(canEdit){
    document.getElementById('addQuestionBtn').addEventListener('click', function(){
      document.getElementById('questionForm').reset();
      document.getElementById('questionId').value = '';
      document.getElementById('questionModalLabel').textContent = 'Add Question';
      updateAgendaSelect();
      bootstrap.Modal.getOrCreateInstance(document.getElementById('questionModal')).show();
    });

    document.getElementById('questionsList').addEventListener('click', function(e){
      var tgt = e.target;
      if(tgt.classList.contains('edit-question')){
        var id = tgt.dataset.id;
        var q = questionsData.find(function(item){ return item.id == id; });
        if(q){
          document.getElementById('questionId').value = q.id;
          document.getElementById('questionText').value = q.question_text;
          document.getElementById('answerText').value = q.answer_text || '';
          document.getElementById('agendaSelect').value = q.agenda_id || '';
          document.getElementById('questionModalLabel').textContent = 'Edit Question';
          updateAgendaSelect();
          bootstrap.Modal.getOrCreateInstance(document.getElementById('questionModal')).show();
        }
      } else if(tgt.classList.contains('delete-question')){
        var id = tgt.dataset.id;
        if(confirm('Delete this question?')){
          var fd = new FormData();
          fd.append('id', id);
          fd.append('meeting_id', meetingId);
          fd.append('csrf_token', csrfToken);
          fetchJson('functions/delete_question.php', {method:'POST', body:fd})
            .then(function(res){
              if(res.success){
                questionsData = res.questions;
                renderQuestions();
              } else {
                showToast('Failed to delete question');
              }
            })
            .catch(function(err){ console.error(err); showToast('Failed to delete question'); });
        }
      }
    });

  }

  var attendeesList = document.getElementById('attendeesList');
  var attachmentsList = document.getElementById('attachmentsList');

  function renderAttendees(attendees){
    attendeesData = attendees;
    attendeesList.innerHTML = '';
    if(attendees.length){
      attendees.forEach(function(a){
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-start';
        var info = '<div><div class="fw-bold">' + esc(a.name);
        if(a.role) info += ' (' + esc(a.role) + ')';
        info += '</div><small class="text-body-secondary">Check-in: ' + (a.check_in_time ? new Date(a.check_in_time).toLocaleString() : '-') + ' | Check-out: ' + (a.check_out_time ? new Date(a.check_out_time).toLocaleString() : '-') + '</small></div>';
        if (canEditAttendees){
          info += '<button class="btn btn-sm btn-link text-danger ms-2 remove-attendee" data-id="' + a.id + '">Remove</button>';
        }
        li.innerHTML = info;
        attendeesList.appendChild(li);
      });
    } else {
      attendeesList.innerHTML = '<li class="list-group-item">No attendees.</li>';
    }
  }

  function fetchAttendees(){
    return fetchJson('functions/get_attendees.php?meeting_id=' + meetingId + '&csrf_token=' + csrfToken)
      .then(function(data){
        if(data.success){
          renderAttendees(data.attendees);
        } else {
          renderAttendees([]);
        }
      })
      .catch(function(err){
        console.error(err);
        showToast('Failed to load attendees');
      });
  }

  function renderAttachments(files){
    attachmentsList.innerHTML = '';
    if(files && files.length){
      files.forEach(function(f){
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        var content = '<a href="' + esc(f.url) + '" target="_blank">' + esc(f.name) + '</a>';
        if(canEdit){
          content += '<button class="btn btn-sm btn-link text-danger ms-2 delete-file" data-id="' + f.id + '">Delete</button>';
        }
        li.innerHTML = content;
        attachmentsList.appendChild(li);
      });
    } else {
      attachmentsList.innerHTML = '<li class="list-group-item">No attachments.</li>';
    }
  }

  if(canEditAttendees){
    var attendeeForm = document.getElementById('attendeeForm');
    var attendeeSearch = document.getElementById('attendeeSearch');
    var attendeeId = document.getElementById('attendeeId');
    var attendeeResults = document.getElementById('attendeeResults');

    if(attendeeSearch){
      attendeeSearch.addEventListener('input', function(){
        attendeeId.value = '';
        var q = this.value.trim();
        if(q.length < 2){
          attendeeResults.innerHTML = '';
          return;
        }
        fetchJson('functions/search_users.php?q=' + encodeURIComponent(q))
          .then(function(users){
            attendeeResults.innerHTML = '';
            users.forEach(function(u){
              var btn = document.createElement('button');
              btn.type = 'button';
              btn.className = 'list-group-item list-group-item-action';
              btn.textContent = u.name;
              btn.dataset.id = u.id;
              attendeeResults.appendChild(btn);
            });
          })
          .catch(function(err){
            console.error(err);
            attendeeResults.innerHTML = '<div class="list-group-item">Error searching users</div>';
            showToast('Error searching users');
          });
      });

      attendeeResults.addEventListener('click', function(e){
        var btn = e.target.closest('button[data-id]');
        if(!btn) return;
        var uid = btn.dataset.id;
        if(attendeesData.some(function(a){ return parseInt(a.attendee_user_id,10) === parseInt(uid,10); })){
          showToast('User already added', 'warning');
          return;
        }
        attendeeSearch.value = btn.textContent;
        attendeeId.value = uid;
        attendeeResults.innerHTML = '';
      });
    }

    attendeeForm.addEventListener('submit', function(e){
      e.preventDefault();
      if(!attendeeId.value){
        showToast('Please select a user', 'warning');
        return;
      }
      var formData = new FormData(attendeeForm);
      fetchJson('functions/add_attendee.php', {method:'POST', body:formData})
        .then(function(res){
          if(res.success){
            attendeeForm.reset();
            attendeeResults.innerHTML = '';
            renderAttendees(res.attendees || []);
          } else {
            showToast(res.message || 'Failed to add attendee');
          }
        })
        .catch(function(err){
          console.error(err);
          showToast('Failed to add attendee');
        });
    });

    attendeesList.addEventListener('click', function(e){
      if(e.target.classList.contains('remove-attendee')){
        var id = e.target.getAttribute('data-id');
        var formData = new FormData();
        formData.append('id', id);
        formData.append('meeting_id', meetingId);
        formData.append('csrf_token', csrfToken);
        fetchJson('functions/remove_attendee.php', {method:'POST', body:formData})
          .then(function(res){
            if(res.success){
              renderAttendees(res.attendees || []);
            }
          })
          .catch(function(err){
            console.error(err);
            showToast('Failed to remove attendee');
          });
      }
    });
  }

  fetchJson('functions/get_attachments.php?meeting_id=' + meetingId + '&csrf_token=' + csrfToken)
    .then(function(data){
      if(data.success){
        renderAttachments(data.files);
      } else {
        renderAttachments([]);
      }
    })
    .catch(function(err){ console.error(err); showToast('Failed to load attachments'); });

  var uploadForm = document.getElementById('uploadForm');
  if(uploadForm){
    uploadForm.addEventListener('submit', function(e){
      e.preventDefault();
      var formData = new FormData(uploadForm);
      fetchJson('functions/upload_file.php', {method:'POST', body: formData})
        .then(function(res){
          if(res.success && res.files){
            renderAttachments(res.files);
            uploadForm.reset();
          } else {
            showToast(res.message || 'Upload failed');
          }
        })
        .catch(function(err){ console.error(err); showToast('Upload failed'); });
    });
  }

  if(canEdit){
    attachmentsList.addEventListener('click', function(e){
      if(e.target.classList.contains('delete-file')){
        e.preventDefault();
        var id = e.target.getAttribute('data-id');
        var fd = new FormData();
        fd.append('id', id);
        fd.append('meeting_id', meetingId);
        fd.append('csrf_token', csrfToken);
        fetchJson('functions/delete_file.php', {
          method: 'POST',
          body: fd
        })
        .then(function(res){
          if(res.success && res.files){
            renderAttachments(res.files);
          } else {
            showToast(res.message || 'Failed to delete file');
          }
        })
        .catch(function(err){ console.error(err); showToast('Failed to delete file'); });
      }
    });
  }

  document.getElementById('taskForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    var fd = new FormData(form);
    fd.append('csrf_token', csrfToken);
    fetchJson('functions/create_task.php', {method:'POST', body:fd})
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
          form.reset();
        } else {
          showToast(res.message || 'Failed to create task');
        }
      })
      .catch(function(err){ console.error(err); showToast('Failed to create task'); });
  });

  document.getElementById('projectForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    var fd = new FormData(form);
    fd.append('csrf_token', csrfToken);
    fetchJson('functions/create_project.php', {method:'POST', body:fd})
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
          form.reset();
        } else {
          showToast(res.message || 'Failed to create project');
        }
      })
      .catch(function(err){ console.error(err); showToast('Failed to create project'); });
  });

  function esc(str){
      if (str === null || str === undefined) return '';
      return String(str)
        .replace(/&/g,'&amp;')
        .replace(/</g,'&lt;')
        .replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;')
        .replace(/'/g,'&#039;');
    }
});
</script>
