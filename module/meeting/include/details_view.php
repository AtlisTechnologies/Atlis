<?php
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
        <div class="card-header">Questions</div>
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
        <div class="card-body p-0">
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

<script src="<?php echo getURLDir(); ?>vendors/sortablejs/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var meetingId = <?php echo (int)$meeting['id']; ?>;
  var canEditAttendees = <?php echo user_has_permission('meeting','update') ? 'true' : 'false'; ?>;
  var allUsers = <?php echo json_encode($allUsers); ?>;
  var agendaList = document.getElementById('agendaList');
  new Sortable(agendaList, {handle: '.drag-handle', animation:150});

  fetch('functions/get_agenda.php?meeting_id=' + meetingId)
    .then(r => r.json())
    .then(function(data){
      if(data.success && data.items.length){
        fetch('include/agenda_item.php').then(r=>r.text()).then(function(template){
          data.items.forEach(function(item){
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
        });
      } else {
        var li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = 'No agenda items.';
        agendaList.appendChild(li);
      }
    });

  fetch('functions/get_questions.php?meeting_id=' + meetingId)
    .then(r=>r.json())
    .then(function(data){
      var container = document.getElementById('questionsList');
      if(data.success && data.questions.length){
        data.questions.forEach(function(q){
          var div = document.createElement('div');
          div.className = 'mb-3';
          div.innerHTML = '<p class="fw-bold mb-1">' + esc(q.question) + '</p><p class="mb-0">' + esc(q.answer || '') + '</p>';
          container.appendChild(div);
        });
      } else {
        container.innerHTML = '<p class="text-body-secondary mb-0">No questions.</p>';
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
