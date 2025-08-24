<?php
$questionStatusMap = array_column(get_lookup_items($pdo, 'MEETING_QUESTION_STATUS'), null, 'id');
$usersStmt = $pdo->query('SELECT u.id AS user_id, CONCAT(p.first_name, " ", p.last_name) AS name FROM users u LEFT JOIN person p ON u.id = p.user_id ORDER BY name');
$allUsers = $usersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container-fluid py-4">
  <div class="row mb-3">
    <div class="col">
      <h2><?php echo h($meeting['title'] ?? 'Meeting'); ?></h2>
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
            <div class="col-md-4">
              <select class="form-select" name="attendee_user_id">
                <?php foreach ($allUsers as $u): ?>
                  <option value="<?php echo (int)$u['user_id']; ?>"><?php echo h($u['name']); ?></option>
                <?php endforeach; ?>
              </select>
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
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="questionForm">
      <div class="modal-header">
        <h5 class="modal-title" id="questionModalLabel">Add Question</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="meeting_id" value="<?php echo (int)$meeting['id']; ?>">
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
        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status_id" id="statusSelect" class="form-select">
            <option value="">None</option>
            <?php foreach ($questionStatusMap as $sid => $s): ?>
              <option value="<?= (int)$sid ?>"><?= h($s['label']); ?></option>
            <?php endforeach; ?>
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
  var questionStatusMap = <?php echo json_encode($questionStatusMap); ?>;
  var agendaMap = {};
  var questionsData = [];
  var agendaList = document.getElementById('agendaList');
  new Sortable(agendaList, {handle: '.drag-handle', animation:150, onEnd: updateOrder});

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

  fetch('functions/get_agenda.php?meeting_id=' + meetingId)
    .then(r => r.json())
    .then(function(data){
      if(data.success && data.items.length){
        fetch('include/agenda_item.php').then(r=>r.text()).then(function(template){
          data.items.forEach(function(item){
            agendaMap[item.id] = item.title;
            var temp = document.createElement('div');
            temp.innerHTML = template.trim();
            var li = temp.firstElementChild;
            li.querySelector('input[name="agenda_titles[]"]').value = item.title;
            li.querySelector('input[name="agenda_presenters[]"]').value = item.presenter || '';
            li.querySelector('input[name="agenda_durations[]"]').value = item.duration || '';
            li.querySelectorAll('input').forEach(function(i){ i.disabled = true; });
            var btn = li.querySelector('.remove-agenda-item');
            if(btn) btn.remove();
            agendaList.appendChild(li);
          });
          updateAgendaSelect();
        });
      } else {
        var li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.dataset.id = item.id;
        li.dataset.statusId = item.status_id || '';
        li.dataset.taskId = item.linked_task_id || '';
        li.dataset.projectId = item.linked_project_id || '';
        var left = '<span><span class="drag-handle me-2 fas fa-grip-vertical"></span><span class="agenda-title">'+esc(item.title)+'</span>';
        var meta = [];
        if(item.status_id){ meta.push('Status '+esc(item.status_id)); }
        if(item.linked_task_id){ meta.push('<a href="'+baseUrl+'module/task/index.php?id='+item.linked_task_id+'">Task '+esc(item.linked_task_id)+'</a>'); }
        if(item.linked_project_id){ meta.push('<a href="'+baseUrl+'module/project/index.php?id='+item.linked_project_id+'">Project '+esc(item.linked_project_id)+'</a>'); }
        if(meta.length){ left += ' <small class="text-body-secondary">'+meta.join(' | ')+'</small>'; }
        left += '</span>';
        li.innerHTML = left + '<div class="btn-group btn-group-sm"><button class="btn btn-outline-secondary edit-agenda-item">Edit</button><button class="btn btn-outline-danger delete-agenda-item">Delete</button></div>';
        agendaList.appendChild(li);
        updateAgendaSelect();
      }
    });
  }

  agendaList.addEventListener('click', function(e){
    var li = e.target.closest('li[data-id]');
    if(!li) return;
    if(e.target.closest('.delete-agenda-item')){
      var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId});
      fetch('functions/delete_agenda_item.php', {method:'POST', body: params})
        .then(r=>r.json())
        .then(function(res){ if(res.success) renderAgenda(res.items); });
    } else if(e.target.closest('.edit-agenda-item')){
      var newTitle = prompt('Title', li.querySelector('.agenda-title').textContent);
      if(newTitle !== null){
        var newStatus = prompt('Status ID', li.dataset.statusId);
        var newTask = prompt('Task ID', li.dataset.taskId);
        var newProject = prompt('Project ID', li.dataset.projectId);
        var params = new URLSearchParams({id: li.dataset.id, meeting_id: meetingId, order_index: Array.from(agendaList.children).indexOf(li)+1, title: newTitle, status_id: newStatus, linked_task_id: newTask, linked_project_id: newProject});
        fetch('functions/update_agenda_item.php', {method:'POST', body: params})
          .then(r=>r.json())
          .then(function(res){ if(res.success) renderAgenda(res.items); });
      }
    }
  });

  fetchAgenda();

  function loadQuestions(){
    var fd = new FormData();
    fd.append('meeting_id', meetingId);
    fetch('functions/update_question.php', {method:'POST', body:fd})
      .then(r=>r.json())
      .then(function(res){
        if(res.success){
          questionsData = res.questions;
          renderQuestions();
        }
      });
  }

  function renderQuestions(){
    var container = document.getElementById('questionsList');
    container.innerHTML = '';
    if(questionsData.length){
      questionsData.forEach(function(q){
        var div = document.createElement('div');
        div.className = 'mb-3';
        div.dataset.id = q.id;
        var statusHtml = '';
        if(q.status_id && questionStatusMap[q.status_id]){
          var s = questionStatusMap[q.status_id];
          statusHtml = '<span class="badge bg-' + esc(s.color_class || 'secondary') + ' me-2">' + esc(s.label) + '</span>';
        }
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
          + statusHtml
          + '</div>'
          + (canEdit ? '<div class="mt-2 text-end"><button class="btn btn-sm btn-secondary me-1 edit-question" data-id="'+q.id+'">Edit</button><button class="btn btn-sm btn-danger delete-question" data-id="'+q.id+'">Delete</button></div>' : '');
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
          document.getElementById('statusSelect').value = q.status_id || '';
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
          fetch('functions/delete_question.php', {method:'POST', body:fd})
            .then(r=>r.json())
            .then(function(res){
              if(res.success){
                questionsData = res.questions;
                renderQuestions();
              } else {
                alert('Failed to delete question');
              }
            });
        }
      }
    });

  var attendeesList = document.getElementById('attendeesList');

  function renderAttendees(attendees){
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
    updateUserOptions(attendees);
  }

  function updateUserOptions(attendees){
    if(!canEditAttendees) return;
    var select = document.querySelector('#attendeeForm select[name="attendee_user_id"]');
    if(!select) return;
    var selected = attendees.map(function(a){ return parseInt(a.attendee_user_id,10); });
    select.innerHTML = '';
    allUsers.forEach(function(u){
      if(selected.indexOf(parseInt(u.user_id,10)) === -1){
        var opt = document.createElement('option');
        opt.value = u.user_id;
        opt.textContent = u.name;
        select.appendChild(opt);
      }
    });
  }

  if(canEditAttendees){
    var attendeeForm = document.getElementById('attendeeForm');
    attendeeForm.addEventListener('submit', function(e){
      e.preventDefault();
      var formData = new FormData(attendeeForm);
      fetch('functions/add_attendee.php', {method:'POST', body:formData})
        .then(r=>r.json())
        .then(function(res){
          if(res.success){
            attendeeForm.reset();
            renderAttendees(res.attendees);
          } else {
            alert(res.message || 'Failed to add attendee');
          }
        });
    });

    attendeesList.addEventListener('click', function(e){
      if(e.target.classList.contains('remove-attendee')){
        var id = e.target.getAttribute('data-id');
        var formData = new FormData();
        formData.append('id', id);
        formData.append('meeting_id', meetingId);
        fetch('functions/remove_attendee.php', {method:'POST', body:formData})
          .then(r=>r.json())
          .then(function(res){
            if(res.success){
              renderAttendees(res.attendees);
            }
          });
      }
    });
  }

  fetch('functions/get_attendees.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      if(data.success){
        renderAttendees(data.attendees);
      } else {
        renderAttendees([]);
      }
    });

  fetch('functions/get_attachments.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      var list = document.getElementById('attachmentsList');
      if(data.success && data.files.length){
        data.files.forEach(function(f){
          var li = document.createElement('li');
          li.className = 'list-group-item';
          li.innerHTML = '<a href="' + esc(f.url) + '" target="_blank">' + esc(f.name) + '</a>';
          list.appendChild(li);
        });
      } else {
        list.innerHTML = '<li class="list-group-item">No attachments.</li>';
      }
    });

  var uploadForm = document.getElementById('uploadForm');
  if(uploadForm){
    uploadForm.addEventListener('submit', function(e){
      e.preventDefault();
      var formData = new FormData(uploadForm);
      fetch('functions/upload_file.php', {method:'POST', body: formData})
        .then(r=>r.json())
        .then(function(res){
          if(res.success && res.files){
            var list = document.getElementById('attachmentsList');
            if(list.children.length === 1 && list.firstElementChild.textContent === 'No attachments.'){
              list.innerHTML = '';
            }
            res.files.forEach(function(f){
              var li = document.createElement('li');
              li.className = 'list-group-item';
              li.innerHTML = '<a href="' + esc(f.url) + '" target="_blank">' + esc(f.name) + '</a>';
              list.appendChild(li);
            });
            uploadForm.reset();
          } else {
            alert(res.message || 'Upload failed');
          }
        });
    });
  }

  document.getElementById('taskForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    fetch('functions/create_task.php', {method:'POST', body:new FormData(form)})
      .then(r=>r.json())
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('taskModal')).hide();
          form.reset();
        } else {
          alert(res.message || 'Failed to create task');
        }
      });
  });

  document.getElementById('projectForm').addEventListener('submit', function(e){
    e.preventDefault();
    var form = this;
    fetch('functions/create_project.php', {method:'POST', body:new FormData(form)})
      .then(r=>r.json())
      .then(function(res){
        if(res.success){
          bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
          form.reset();
        } else {
          alert(res.message || 'Failed to create project');
        }
      });
  });

  function esc(str){
    return str ? str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;') : '';
  }
});
</script>
