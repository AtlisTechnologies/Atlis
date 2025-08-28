<?php
require '../admin_header.php';
require_permission('admin_corporate','read');

$token = generate_csrf_token();

// Load corporate settings (single row)
$stmt = $pdo->query('SELECT * FROM admin_corporate LIMIT 1');
$corporate = $stmt->fetch(PDO::FETCH_ASSOC) ?: ['id'=>0,'name'=>'','description'=>''];
?>
<h2 class="mb-4">Corporate Settings</h2>
<div id="flash"></div>
<form id="corporateForm" class="card mb-4">
  <div class="card-body">
    <input type="hidden" name="csrf_token" value="<?= $token; ?>">
    <input type="hidden" name="id" value="<?= (int)$corporate['id']; ?>">
    <div class="mb-3">
      <label class="form-label" for="name">Name</label>
      <input class="form-control" type="text" id="name" name="name" value="<?= e($corporate['name']); ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label" for="description">Description</label>
      <textarea class="form-control" id="description" name="description" rows="3"><?= e($corporate['description']); ?></textarea>
    </div>
    <?php if (user_has_permission('admin_corporate','update')): ?>
    <button class="btn btn-primary" type="submit">Save Settings</button>
    <?php endif; ?>
  </div>
</form>

<div class="row">
  <?php if (user_has_permission('admin_corporate_notes','read')): ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Notes</h5>
      </div>
      <div class="card-body">
        <ul class="list-unstyled" id="notesList">
          <?php
          $nstmt = $pdo->prepare('SELECT id, note_text FROM admin_corporate_notes WHERE corporate_id = :id ORDER BY date_created DESC');
          $nstmt->execute([':id' => $corporate['id']]);
          foreach ($nstmt as $n): ?>
          <li class="d-flex justify-content-between align-items-start mb-2" data-note-id="<?= (int)$n['id']; ?>">
            <span><?= e($n['note_text']); ?></span>
            <span>
              <?php if (user_has_permission('admin_corporate_notes','update')): ?><button class="btn btn-sm btn-outline-secondary edit-note">Edit</button><?php endif; ?>
              <?php if (user_has_permission('admin_corporate_notes','delete')): ?><button class="btn btn-sm btn-outline-danger delete-note">Delete</button><?php endif; ?>
            </span>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php if (user_has_permission('admin_corporate_notes','create')): ?>
        <form id="noteForm" class="mt-3">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <input type="hidden" name="corporate_id" value="<?= (int)$corporate['id']; ?>">
          <textarea class="form-control mb-2" name="note_text" rows="2" placeholder="Add note" required></textarea>
          <button class="btn btn-sm btn-primary" type="submit">Add Note</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <?php if (user_has_permission('admin_corporate_files','read')): ?>
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header"><h5 class="mb-0">Files</h5></div>
      <div class="card-body">
        <ul class="list-unstyled" id="filesList">
          <?php
          $fstmt = $pdo->prepare('SELECT id, file_name, file_path FROM admin_corporate_files WHERE corporate_id = :id ORDER BY date_created DESC');
          $fstmt->execute([':id' => $corporate['id']]);
          foreach ($fstmt as $f): ?>
          <li class="d-flex justify-content-between align-items-start mb-2" data-file-id="<?= (int)$f['id']; ?>">
            <a href="<?= getURLDir() . e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a>
            <?php if (user_has_permission('admin_corporate_files','delete')): ?><button class="btn btn-sm btn-outline-danger delete-file">Delete</button><?php endif; ?>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php if (user_has_permission('admin_corporate_files','create')): ?>
        <form id="fileForm" class="mt-3" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?= $token; ?>">
          <input type="hidden" name="corporate_id" value="<?= (int)$corporate['id']; ?>">
          <input type="file" name="file" class="form-control form-control-sm mb-2" required>
          <button class="btn btn-sm btn-primary" type="submit">Upload</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const flash = document.getElementById('flash');
  function showFlash(msg, type='success'){
    flash.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${msg}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
  }
  function escapeHtml(str){
    return str.replace(/[&<>'"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c]));
  }
  const corpForm = document.getElementById('corporateForm');
  corpForm && corpForm.addEventListener('submit', e => {
    e.preventDefault();
    fetch('functions/update.php', {method:'POST', body:new FormData(corpForm)})
      .then(r => r.json())
      .then(d => { d.success ? showFlash('Settings saved') : showFlash(d.error || 'Error','danger'); })
      .catch(() => showFlash('Server error','danger'));
  });

  const noteForm = document.getElementById('noteForm');
  noteForm && noteForm.addEventListener('submit', e => {
    e.preventDefault();
    fetch('functions/add_note.php',{method:'POST',body:new FormData(noteForm)})
      .then(r=>r.json()).then(d=>{
        if(d.success && d.note){
          const li = document.createElement('li');
          li.className='d-flex justify-content-between align-items-start mb-2';
          li.dataset.noteId = d.note.id;
          li.innerHTML = `<span>${escapeHtml(d.note.note_text)}</span><span><?php if (user_has_permission('admin_corporate_notes','update')): ?><button class="btn btn-sm btn-outline-secondary edit-note">Edit</button><?php endif; ?> <?php if (user_has_permission('admin_corporate_notes','delete')): ?><button class="btn btn-sm btn-outline-danger delete-note">Delete</button><?php endif; ?></span>`;
          document.getElementById('notesList').prepend(li);
          noteForm.reset();
          showFlash('Note added');
        }else{
          showFlash(d.error || 'Error','danger');
        }
      }).catch(()=>showFlash('Server error','danger'));
  });

  const notesList = document.getElementById('notesList');
  notesList && notesList.addEventListener('click', e => {
    const li = e.target.closest('li');
    if(!li) return;
    if(e.target.classList.contains('delete-note')){
      const fd = new FormData();
      fd.append('id', li.dataset.noteId);
      fd.append('csrf_token', '<?= $token; ?>');
      fetch('functions/delete_note.php',{method:'POST',body:fd})
        .then(r=>r.json()).then(d=>{
          if(d.success){ li.remove(); showFlash('Note deleted'); } else { showFlash(d.error || 'Error','danger'); }
        }).catch(()=>showFlash('Server error','danger'));
    } else if(e.target.classList.contains('edit-note')){
      const current = li.querySelector('span').textContent.trim();
      const updated = prompt('Edit note', current);
      if(updated !== null && updated !== current){
        const fd = new FormData();
        fd.append('id', li.dataset.noteId);
        fd.append('note_text', updated);
        fd.append('csrf_token', '<?= $token; ?>');
        fetch('functions/edit_note.php',{method:'POST',body:fd})
          .then(r=>r.json()).then(d=>{
            if(d.success){ li.querySelector('span').textContent = updated; showFlash('Note updated'); } else { showFlash(d.error || 'Error','danger'); }
          }).catch(()=>showFlash('Server error','danger'));
      }
    }
  });

  const fileForm = document.getElementById('fileForm');
  fileForm && fileForm.addEventListener('submit', e => {
    e.preventDefault();
    fetch('functions/upload_file.php',{method:'POST',body:new FormData(fileForm)})
      .then(r=>r.json()).then(d=>{
        if(d.success && d.file){
          const li = document.createElement('li');
          li.className='d-flex justify-content-between align-items-start mb-2';
          li.dataset.fileId = d.file.id;
          li.innerHTML = `<a href="${escapeHtml(d.file.file_path)}" target="_blank">${escapeHtml(d.file.file_name)}</a><?php if (user_has_permission('admin_corporate_files','delete')): ?> <button class="btn btn-sm btn-outline-danger delete-file">Delete</button><?php endif; ?>`;
          document.getElementById('filesList').prepend(li);
          fileForm.reset();
          showFlash('File uploaded');
        }else{
          showFlash(d.error || 'Upload failed','danger');
        }
      }).catch(()=>showFlash('Server error','danger'));
  });

  const filesList = document.getElementById('filesList');
  filesList && filesList.addEventListener('click', e => {
    if(e.target.classList.contains('delete-file')){
      const li = e.target.closest('li');
      const fd = new FormData();
      fd.append('id', li.dataset.fileId);
      fd.append('csrf_token', '<?= $token; ?>');
      fetch('functions/delete_file.php',{method:'POST',body:fd})
        .then(r=>r.json()).then(d=>{
          if(d.success){ li.remove(); showFlash('File deleted'); } else { showFlash(d.error || 'Error','danger'); }
        }).catch(()=>showFlash('Server error','danger'));
    }
  });
});
</script>
<?php require '../admin_footer.php'; ?>
