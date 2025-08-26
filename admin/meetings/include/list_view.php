<?php $token = generate_csrf_token(); ?>
<div class="p-4" id="meetingList" data-list='{"valueNames":["meeting-title","start-time"],"page":25,"pagination":true}'>
  <h2 class="mb-4">Meetings<span class="text-body-tertiary fw-normal">(<?= count($meetings) ?>)</span></h2>
  <div class="row align-items-center g-3 mb-3">
    <div class="col-sm-auto">
      <div class="search-box">
        <form class="position-relative">
          <input class="form-control search-input search" type="search" placeholder="Search meetings" aria-label="Search" />
          <span class="fas fa-search search-box-icon"></span>
        </form>
      </div>
    </div>
    <?php if (user_has_permission('meeting','create')): ?>
    <div class="col-sm-auto">
      <a href="index.php?action=create" class="btn btn-primary">Create Meeting</a>
    </div>
    <?php endif; ?>
  </div>
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
  <div class="mb-4 list" id="meetingListContainer">
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
  <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
    <div class="col-auto d-flex">
      <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
    </div>
    <div class="col-auto d-flex">
      <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
      <ul class="mb-0 pagination"></ul>
      <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var meetingList = new List('meetingList', { valueNames: ['meeting-title','start-time'], page:25, pagination:true });
  var form = document.getElementById('meetingQuickAdd');
  if(form){
    form.addEventListener('submit', function(e){
      e.preventDefault();
      var data = new FormData(form);
      data.append('ajax',1);
      data.append('csrf_token', form.querySelector('input[name="csrf_token"]').value);
      fetch('functions/create.php',{method:'POST',body:data})
        .then(r=>r.json())
        .then(function(res){
          if(res.success && res.meeting){
            var html = `<div class="row align-items-center border-top py-3 gx-0 meeting-row" data-id="${res.meeting.id}">`+
                       `<div class="col"><a class="meeting-title fw-bold" href="index.php?action=details&id=${res.meeting.id}">${res.meeting.title}</a></div>`+
                       `<div class="col-auto text-body-tertiary start-time">${res.meeting.start_time || ''}</div></div>`;
            document.getElementById('meetingListContainer').insertAdjacentHTML('afterbegin', html);
            meetingList.add({'meeting-title': res.meeting.title, 'start-time': res.meeting.start_time});
          }
          form.reset();
        });
    });
  }
});
</script>
