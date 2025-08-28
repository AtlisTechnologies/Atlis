<?php $token = generate_csrf_token(); ?>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>
<div class="p-4" id="meetingList">
  <h2 class="mb-4">Meetings<span class="text-body-tertiary fw-normal">(<?= count($meetings) ?>)</span></h2>
  <div class="row g-3 mb-3">
    <div class="col-12">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control" id="meetingSearch" type="search" placeholder="Search meetings" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
  </div>
  <hr class="mb-3" />
  <?php if (user_has_permission('meeting','create')): ?>
  <form id="meetingQuickAdd" class="row g-2 align-items-center mb-3">
    <input type="hidden" name="csrf_token" value="<?= h($token); ?>">
    <div class="col-md-6">
      <input class="form-control" type="text" name="title" placeholder="Meeting title" required>
    </div>
    <div class="col-md-4">
      <input class="form-control" type="datetime-local" name="start_time" required>
    </div>
    <div class="col-md-2">
      <button class="btn btn-success w-100" type="submit">Add</button>
    </div>
  </form>
  <?php endif; ?>
  <div class="mb-4" id="meetingListContainer">
    <?php foreach ($meetings as $m): ?>
      <div class="row align-items-center border-top py-3 gx-0 meeting-row" data-id="<?= (int)$m['id'] ?>">
        <div class="col">
          <a class="meeting-title fw-bold" href="index.php?action=details&id=<?= (int)$m['id'] ?>"><?= h($m['title'] ?? '') ?></a>
        </div>
        <div class="col-auto text-body-tertiary start-time"><?= !empty($m['start_time']) ? h(date('d M, Y g:i A', strtotime($m['start_time']))) : '' ?></div>
      </div>
    <?php endforeach; ?>
    <?php if (empty($meetings)): ?>
      <p class="fs-9 text-body-secondary mb-0">No meetings found.</p>
    <?php endif; ?>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  function showToast(msg, type = 'success'){
    var container = document.getElementById('toastContainer');
    if(!container){
      alert(msg);
      return;
    }
    var toastEl = document.createElement('div');
    toastEl.className = 'toast align-items-center text-bg-' + type + ' border-0';
    toastEl.setAttribute('role', 'alert');
    toastEl.setAttribute('aria-live', 'assertive');
    toastEl.setAttribute('aria-atomic', 'true');
    toastEl.innerHTML = '<div class="d-flex"><div class="toast-body">'+msg+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
    container.appendChild(toastEl);
    new bootstrap.Toast(toastEl).show();
  }

  var searchInput = document.getElementById('meetingSearch');
  var searchTimeout;
  var listContainer = document.getElementById('meetingListContainer');
  var originalListHTML = listContainer ? listContainer.innerHTML : '';
  if(searchInput){
    searchInput.addEventListener('input', function(){
      clearTimeout(searchTimeout);
      var q = this.value.trim();
      searchTimeout = setTimeout(function(){
        if(q === ''){
          listContainer.innerHTML = originalListHTML;
          return;
        }
        fetch('functions/search.php?q=' + encodeURIComponent(q))
          .then(function(r){
            if(!r.ok){
              return r.text().then(function(text){ throw new Error(text || r.statusText); });
            }
            return r.json();
          })
          .then(function(res){
            if(res.success){
              listContainer.innerHTML = '';
              if(res.meetings && res.meetings.length){
                res.meetings.forEach(function(m){
                  var row = `<div class="row align-items-center border-top py-3 gx-0 meeting-row" data-id="${m.id}">`+
                            `<div class="col"><a class="meeting-title fw-bold" href="index.php?action=details&id=${m.id}">${m.title}</a></div>`+
                            `<div class="col-auto text-body-tertiary start-time">${m.start_time || ''}</div></div>`;
                  listContainer.insertAdjacentHTML('beforeend', row);
                });
              } else {
                listContainer.innerHTML = '<p class="fs-9 text-body-secondary mb-0">No meetings found.</p>';
              }
            }
          })
          .catch(function(err){ console.error(err); });
      },300);
    });
  }

  var form = document.getElementById('meetingQuickAdd');
  if(form){
    var submitBtn = form.querySelector('button[type="submit"]');
    var spinner = document.createElement('span');
    spinner.className = 'spinner-border spinner-border-sm me-2 d-none';
    spinner.setAttribute('role','status');
    spinner.setAttribute('aria-hidden','true');
    if(submitBtn){
      submitBtn.prepend(spinner);
    }
    form.addEventListener('submit', function(e){
      e.preventDefault();
      if(submitBtn){
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
      }
      var data = new FormData(form);
      data.append('ajax',1);
      data.append('csrf_token', form.querySelector('input[name="csrf_token"]').value);
      fetch('functions/create.php',{method:'POST',body:data})
        .then(function(r){
          if(!r.ok){
            return r.text().then(function(text){
              showToast(text,'danger');
              throw new Error(text || r.statusText);
            });
          }
          return r.json();
        })
        .then(function(res){
          if(res.success){
            showToast('Meeting created','success');
            var id = res.id || (res.meeting && res.meeting.id);
            if(id){
              setTimeout(function(){
                window.location = 'index.php?action=edit&id=' + id;
              }, 1000);
            }
          } else {
            showToast('Creation failed','danger');
          }
        })
        .catch(function(err){
          console.error(err);
          if(!err.message){
            showToast('Creation failed','danger');
          }
        })
        .finally(function(){
          if(submitBtn){
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
          }
        });
    });
  }
});
</script>
