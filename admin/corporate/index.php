<?php
require '../admin_header.php';
require_permission('corporate','read');

$token = generate_csrf_token();

$sql = "SELECT c.id, c.name, f.label AS feature_label
        FROM module_corporate c
        LEFT JOIN lookup_list_items f ON c.feature_id = f.id
        ORDER BY c.date_created DESC";
$corporates = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$features = get_lookup_items($pdo, 'CORPORATE_FEATURE');
?>
<h2 class="mb-4">Corporate</h2>
<?= flash_message($_SESSION['message'] ?? '', 'success'); ?>
<?= flash_message($_SESSION['error_message'] ?? '', 'danger'); ?>
<?php unset($_SESSION['message'], $_SESSION['error_message']); ?>
<?php if (user_has_permission('corporate','create')): ?>
<div class="mb-3">
  <button class="btn btn-sm btn-success" id="addCorporateBtn">Add Corporate</button>
</div>
<?php endif; ?>
<div id="corporates" data-list='{"valueNames":["id","name","feature"],"page":25,"pagination":true}'>
  <div class="row justify-content-between g-2 mb-3">
    <div class="col-auto">
      <input class="form-control form-control-sm search" placeholder="Search" />
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm mb-0">
      <thead>
        <tr>
          <th class="sort" data-sort="id">ID</th>
          <th class="sort" data-sort="name">Name</th>
          <th class="sort" data-sort="feature">Feature</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list">
        <?php foreach ($corporates as $c): ?>
        <tr data-corporate-id="<?= (int)$c['id']; ?>">
          <td class="id"><?= e($c['id']); ?></td>
          <td class="name"><?= e($c['name']); ?></td>
          <td class="feature"><?= e($c['feature_label']); ?></td>
          <td>
            <?php if (user_has_permission('corporate','update')): ?>
            <button class="btn btn-sm btn-warning edit-corporate" data-id="<?= (int)$c['id']; ?>">Edit</button>
            <?php endif; ?>
            <?php if (user_has_permission('corporate','delete')): ?>
            <form method="post" action="functions/delete.php" class="d-inline" onsubmit="return confirm('Delete this record?');">
              <input type="hidden" name="id" value="<?= (int)$c['id']; ?>">
              <input type="hidden" name="csrf_token" value="<?= $token; ?>">
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td colspan="4">
            <div class="row g-3">
              <div class="col-md-6">
                <h5>Notes</h5>
                <ul class="list-unstyled" id="notes-<?= (int)$c['id']; ?>">
                  <?php
                  $nstmt = $pdo->prepare('SELECT id, note_text FROM module_corporate_notes WHERE corporate_id = :id ORDER BY date_created DESC');
                  $nstmt->execute([':id' => $c['id']]);
                  foreach ($nstmt as $n): ?>
                  <li data-note-id="<?= (int)$n['id']; ?>" class="d-flex justify-content-between">
                    <span><?= e($n['note_text']); ?></span>
                    <?php if (user_has_permission('corporate','update')): ?>
                    <div>
                      <button class="btn btn-sm btn-outline-warning edit-note" data-id="<?= (int)$n['id']; ?>">Edit</button>
                      <?php endif; if (user_has_permission('corporate','delete')): ?>
                      <button class="btn btn-sm btn-outline-danger delete-note" data-id="<?= (int)$n['id']; ?>">Delete</button>
                    </div>
                    <?php endif; ?>
                  </li>
                  <?php endforeach; ?>
                </ul>
                <?php if (user_has_permission('corporate','update')): ?>
                <form class="note-form" data-id="<?= (int)$c['id']; ?>">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <input type="hidden" name="corporate_id" value="<?= (int)$c['id']; ?>">
                  <textarea class="form-control mb-2" name="note_text" rows="2" placeholder="Add note" required></textarea>
                  <button class="btn btn-sm btn-primary">Add Note</button>
                </form>
                <?php endif; ?>
              </div>
              <div class="col-md-6">
                <h5>Files</h5>
                <ul class="list-unstyled" id="files-<?= (int)$c['id']; ?>">
                  <?php
                  $fstmt = $pdo->prepare('SELECT id, file_name, file_path FROM module_corporate_files WHERE corporate_id = :id ORDER BY date_created DESC');
                  $fstmt->execute([':id' => $c['id']]);
                  foreach ($fstmt as $f): ?>
                  <li data-file-id="<?= (int)$f['id']; ?>" class="d-flex justify-content-between">
                    <a href="<?= getURLDir() . e($f['file_path']); ?>" target="_blank"><?= e($f['file_name']); ?></a>
                    <?php if (user_has_permission('corporate','delete')): ?>
                    <button class="btn btn-sm btn-outline-danger delete-file" data-id="<?= (int)$f['id']; ?>">Delete</button>
                    <?php endif; ?>
                  </li>
                  <?php endforeach; ?>
                </ul>
                <?php if (user_has_permission('corporate','create')): ?>
                <form class="file-form" data-id="<?= (int)$c['id']; ?>" enctype="multipart/form-data">
                  <input type="hidden" name="csrf_token" value="<?= $token; ?>">
                  <input type="hidden" name="corporate_id" value="<?= (int)$c['id']; ?>">
                  <input type="file" name="file" class="form-control form-control-sm mb-2" required>
                  <button class="btn btn-sm btn-primary">Upload</button>
                </form>
                <?php endif; ?>
              </div>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>

<div class="modal fade" id="corporateModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="corporateForm">
      <div class="modal-header">
        <h5 class="modal-title" id="corporateModalLabel">Add Corporate</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="corporateAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="corporate-id">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" id="corporate-name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Feature</label>
          <select name="feature_id" id="corporate-feature" class="form-select">
            <option value="">--</option>
            <?php foreach ($features as $f): ?>
            <option value="<?= $f['id']; ?>"><?= e($f['label']); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Memo</label>
          <textarea name="memo" id="corporate-memo" class="form-control" rows="3"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const csrfToken = '<?= $token; ?>';
  const corporateModal = new bootstrap.Modal(document.getElementById('corporateModal'));
  const corporateForm = document.getElementById('corporateForm');
  const corporateAlert = document.getElementById('corporateAlert');
  const corporateModalLabel = document.getElementById('corporateModalLabel');
  const corporatesTableBody = document.querySelector('#corporates tbody.list');
  const addCorporateBtn = document.getElementById('addCorporateBtn');
  const jsonHeaders = {
    'X-Requested-With': 'XMLHttpRequest',
    'Accept': 'application/json'
  };
  let corpList;
  const options = JSON.parse(document.getElementById('corporates').dataset.list);
  if (window.List) {
    corpList = new window.List('corporates', options);
  }

  function showAlert(message, type = 'danger') {
    corporateAlert.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
  }

  function escapeHtml(text = '') {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  addCorporateBtn && addCorporateBtn.addEventListener('click', () => {
    corporateForm.reset();
    document.getElementById('corporate-id').value = '';
    corporateAlert.innerHTML = '';
    corporateModalLabel.textContent = 'Add Corporate';
    corporateModal.show();
  });

  document.querySelectorAll('.edit-corporate').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;
      const tr = btn.closest('tr');
      document.getElementById('corporate-id').value = id;
      document.getElementById('corporate-name').value = tr.querySelector('.name').textContent.trim();
      const featureText = tr.querySelector('.feature').textContent.trim();
      document.getElementById('corporate-feature').value = Array.from(document.getElementById('corporate-feature').options).find(o => o.text === featureText)?.value || '';
      corporateAlert.innerHTML = '';
      corporateModalLabel.textContent = 'Edit Corporate';
      corporateModal.show();
    });
  });

  corporateForm.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(corporateForm);
    const action = formData.get('id') ? 'update.php' : 'create.php';
    fetch('functions/' + action, {
      method: 'POST',
      body: formData,
      headers: jsonHeaders
    })
    .then(res => res.json())
    .then(data => {
      if (data.success && data.corporate) {
        const c = data.corporate;
        let tr = corporatesTableBody.querySelector(`tr[data-corporate-id="${c.id}"]`);
        if (!tr) {
          tr = document.createElement('tr');
          tr.dataset.corporateId = c.id;
          corporatesTableBody.prepend(tr);
        }
        let actions = '';
        <?php if (user_has_permission('corporate','update')): ?>
        actions += `<button class=\"btn btn-sm btn-warning edit-corporate\" data-id=\"${c.id}\">Edit</button>`;
        <?php endif; ?>
        <?php if (user_has_permission('corporate','delete')): ?>
        actions += `<form method=\"post\" action=\"functions/delete.php\" class=\"d-inline\" onsubmit=\"return confirm('Delete this record?');\"><input type=\"hidden\" name=\"id\" value=\"${c.id}\"><input type=\"hidden\" name=\"csrf_token\" value=\"${csrfToken}\"><button class=\"btn btn-sm btn-danger\">Delete</button></form>`;
        <?php endif; ?>
        tr.innerHTML = `<td class=\"id\">${escapeHtml(c.id)}</td><td class=\"name\">${escapeHtml(c.name)}</td><td class=\"feature\">${escapeHtml(c.feature_label || '')}</td><td>${actions}</td>`;
        if (corpList) { corpList.reIndex(); }
        corporateModal.hide();
      } else {
        showAlert(data.error || 'Error');
      }
    })
    .catch(() => showAlert('Server error'));
  });

  document.querySelectorAll('.note-form').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const list = document.getElementById('notes-' + form.dataset.id);
      fetch('functions/add_note.php', {
        method: 'POST',
        body: new FormData(form),
        headers: jsonHeaders
      }).then(r => r.json()).then(d => {
        if (d.success && d.note) {
          const li = document.createElement('li');
          li.dataset.noteId = d.note.id;
          li.className = 'd-flex justify-content-between';
          li.innerHTML = `<span>${escapeHtml(d.note.note_text)}</span><?php if (user_has_permission('corporate','update')): ?> <div><button class=\"btn btn-sm btn-outline-warning edit-note\" data-id=\"${d.note.id}\">Edit</button><?php endif; if (user_has_permission('corporate','delete')): ?> <button class=\"btn btn-sm btn-outline-danger delete-note\" data-id=\"${d.note.id}\">Delete</button></div><?php endif; ?>`;
          list.prepend(li);
          form.reset();
        }
      });
    });
  });

  document.querySelectorAll('.file-form').forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const list = document.getElementById('files-' + form.dataset.id);
      fetch('functions/upload_file.php', {
        method: 'POST',
        body: new FormData(form),
        headers: jsonHeaders
      }).then(r => r.json()).then(d => {
        if (d.success && d.file) {
          const li = document.createElement('li');
          li.dataset.fileId = d.file.id;
          li.className = 'd-flex justify-content-between';
          li.innerHTML = `<a href=\"${escapeHtml(d.file.file_path)}\" target=\"_blank\">${escapeHtml(d.file.file_name)}</a><?php if (user_has_permission('corporate','delete')): ?> <button class=\"btn btn-sm btn-outline-danger delete-file\" data-id=\"${d.file.id}\">Delete</button><?php endif; ?>`;
          list.prepend(li);
          form.reset();
        }
      });
    });
  });

  document.addEventListener('click', e => {
    if (e.target.classList.contains('delete-note')) {
      const id = e.target.dataset.id;
      const li = e.target.closest('li');
      const fd = new FormData();
      fd.append('id', id);
      fd.append('csrf_token', csrfToken);
      fetch('functions/delete_note.php', {method:'POST', body:fd, headers: jsonHeaders})
        .then(r=>r.json()).then(d=>{ if (d.success) { li.remove(); } });
    } else if (e.target.classList.contains('delete-file')) {
      const id = e.target.dataset.id;
      const li = e.target.closest('li');
      const fd = new FormData();
      fd.append('id', id);
      fd.append('csrf_token', csrfToken);
      fetch('functions/delete_file.php', {method:'POST', body:fd, headers: jsonHeaders})
        .then(r=>r.json()).then(d=>{ if (d.success) { li.remove(); } });
    } else if (e.target.classList.contains('edit-note')) {
      const id = e.target.dataset.id;
      const li = e.target.closest('li');
      const current = li.querySelector('span').textContent.trim();
      const newText = prompt('Edit note', current);
      if (newText !== null && newText !== current) {
        const fd = new FormData();
        fd.append('id', id);
        fd.append('note_text', newText);
        fd.append('csrf_token', csrfToken);
        fetch('functions/edit_note.php', {method:'POST', body:fd, headers: jsonHeaders})
          .then(r=>r.json()).then(d=>{ if (d.success) { li.querySelector('span').textContent = newText; } });
      }
    }
  });
});
</script>
<?php require '../admin_footer.php'; ?>
