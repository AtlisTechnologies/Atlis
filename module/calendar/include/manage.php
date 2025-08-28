<?php
require_permission('calendar','read');

$stmt = $pdo->prepare('SELECT id, name, is_private, is_default FROM module_calendar WHERE user_id = ? ORDER BY is_default DESC, name');
$stmt->execute([$this_user_id]);
$calendars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>
<h2 class="mb-3">My Calendars</h2>
<table class="table table-sm align-middle">
  <thead>
    <tr><th>Name</th><th>Private</th><th class="text-end">Actions</th></tr>
  </thead>
  <tbody>
    <?php if ($calendars): foreach ($calendars as $cal): ?>
      <tr data-id="<?= (int)$cal['id']; ?>">
        <td style="width:60%;">
          <input class="form-control form-control-sm cal-name" type="text" value="<?= h($cal['name']); ?>">
        </td>
        <td class="text-center" style="width:10%;">
          <input class="form-check-input cal-private" type="checkbox" value="1"<?= !empty($cal['is_private']) ? ' checked' : ''; ?><?= !empty($cal['is_default']) ? ' disabled' : ''; ?>>
        </td>
        <td class="text-end" style="width:30%;">
          <button class="btn btn-danger btn-sm delete-cal"<?= !empty($cal['is_default']) ? ' disabled' : ''; ?>>Delete</button>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="3">No calendars found.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
<script>
document.addEventListener('DOMContentLoaded', function(){
  function showToast(message, type='success'){
    var container=document.getElementById('toastContainer');
    if(!container){alert(message);return;}
    var toastEl=document.createElement('div');
    toastEl.className='toast align-items-center text-bg-'+type+' border-0';
    toastEl.setAttribute('role','alert');
    toastEl.setAttribute('aria-live','assertive');
    toastEl.setAttribute('aria-atomic','true');
    toastEl.innerHTML='<div class="d-flex"><div class="toast-body">'+message+'</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>';
    container.appendChild(toastEl);
    new bootstrap.Toast(toastEl).show();
  }

  document.querySelectorAll('tr[data-id]').forEach(function(row){
    var id=row.getAttribute('data-id');
    var nameInput=row.querySelector('.cal-name');
    var privCheckbox=row.querySelector('.cal-private');
    var delBtn=row.querySelector('.delete-cal');
    var originalName=nameInput ? nameInput.value : '';
    var originalPriv=privCheckbox ? privCheckbox.checked : false;

    if(nameInput){
      nameInput.addEventListener('change', function(){
        var prev=nameInput.value;
        updateCalendar(id, nameInput.value, privCheckbox && privCheckbox.checked, function(){
          nameInput.value=originalName;
        }, function(){
          originalName=prev;
        });
      });
    }

    if(privCheckbox){
      privCheckbox.addEventListener('change', function(){
        var prev=privCheckbox.checked;
        updateCalendar(id, nameInput ? nameInput.value : '', privCheckbox.checked, function(){
          privCheckbox.checked=originalPriv;
        }, function(){
          originalPriv=prev;
        });
      });
    }

    if(delBtn){
      delBtn.addEventListener('click', function(){
        if(!confirm('Delete this calendar?')) return;
        fetch('functions/delete_calendar.php', {
          method:'POST',
          body:new URLSearchParams({id:id})
        }).then(r=>r.json()).then(function(res){
          if(res.success){
            row.remove();
            showToast('Calendar deleted');
          }else{
            showToast(res.error || 'Delete failed','danger');
          }
        }).catch(function(){showToast('Delete failed','danger');});
      });
    }
  });

  function updateCalendar(id, name, is_private, onFail, onSuccess){
    var data=new URLSearchParams({id:id, name:name});
    if(is_private){data.append('is_private',1);}
    fetch('functions/update_calendar.php', {
      method:'POST',
      body:data
    }).then(r=>r.json()).then(function(res){
      if(res.success){
        showToast('Calendar updated');
        if(onSuccess) onSuccess();
      }else{
        showToast(res.error || 'Update failed','danger');
        if(onFail) onFail();
      }
    }).catch(function(){
      showToast('Update failed','danger');
      if(onFail) onFail();
    });
  }
});
</script>
