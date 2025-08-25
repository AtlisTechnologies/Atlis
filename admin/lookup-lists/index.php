<?php
require '../admin_header.php';

$token = generate_csrf_token();
?>
<h2 class="mb-4">Lookup Lists</h2>
<div id="mainAlert"></div>
<button id="addListBtn" class="btn btn-sm btn-success mb-3">Add Lookup List</button>
<div id="lookup-lists" data-list='{"valueNames":["id","name","description","item-count", "date_updated"],"page":25,"pagination":true}'>
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
          <th class="sort" data-sort="description">Description</th>
          <th class="sort" data-sort="date_updated">Last Updated</th>
          <th class="sort" data-sort="item-count">Item Count</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="list fw-bold" id="listsTableBody"></tbody>
    </table>
  </div>
  <div class="d-flex justify-content-between align-items-center mt-3">
    <p class="mb-0" data-list-info></p>
    <ul class="pagination mb-0"></ul>
  </div>
</div>
<div class="modal fade" id="listModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" id="listForm">
      <div class="modal-header">
        <h5 class="modal-title" id="listModalLabel">Add Lookup List</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="listAlert"></div>
        <input type="hidden" name="csrf_token" value="<?= $token; ?>">
        <input type="hidden" name="id" id="list-id">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" class="form-control" name="name" id="list-name" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" id="list-description"></textarea>
        </div>
        <div class="mb-3">
          <label class="form-label">Memo</label>
          <textarea class="form-control" name="memo" id="list-memo"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="listSaveBtn">
          <span class="spinner-border spinner-border-sm d-none" id="listLoading"></span>
          Save
        </button>
      </div>
    </form>
  </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
  const csrfToken = '<?= $token; ?>';
  const listModal = new bootstrap.Modal(document.getElementById('listModal'));
  const listForm = document.getElementById('listForm');
  const listAlert = document.getElementById('listAlert');
  const mainAlert = document.getElementById('mainAlert');
  const listsTableBody = document.getElementById('listsTableBody');
  const listModalLabel = document.getElementById('listModalLabel');
  const listLoading = document.getElementById('listLoading');
  let listJs;

  function showAlert(container, message, type = 'danger') {
    container.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
  }

  function escapeHtml(text = '') {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  function renderLists(lists) {
    listsTableBody.innerHTML = '';
    if (lists.length === 0) {
      const tr = document.createElement('tr');
      tr.innerHTML = '<td colspan="6" class="text-center">No lookup lists found</td>';
      listsTableBody.appendChild(tr);
      if (listJs) {
        listJs.clear && listJs.clear();
        listJs = null;
      }
    } else {
      lists.forEach(l => {
        const tr = document.createElement('tr');
        tr.dataset.id = l.id;
        tr.innerHTML = `
          <td class="id">${escapeHtml(l.id)}</td>
          <td class="name"><a href="items.php?list_id=${l.id}">${escapeHtml(l.name)}</a></td>
          <td class="description">${escapeHtml(l.description || '')}</td>
          <td class="date_updated">${escapeHtml(l.date_updated || '')}</td>
          <td class="item-count"><span class="badge rounded-pill text-bg-dark">${parseInt(l.item_count,10) || 0}</span></td>
          <td>
            <button class="btn btn-sm btn-warning edit-list" data-id="${l.id}" data-name="${escapeHtml(l.name)}" data-description="${escapeHtml(l.description || '')}" data-memo="${escapeHtml(l.memo || '')}">Edit</button>
            <button class="btn btn-sm btn-danger delete-list" data-id="${l.id}">Delete</button>
          </td>`;
        listsTableBody.appendChild(tr);
      });
    }
    if (!listJs && lists.length) {
      const options = JSON.parse(document.getElementById('lookup-lists').dataset.list);
      listJs = new window.List('lookup-lists', options);
    } else if (listJs) {
      listJs.reIndex();
    }
  }

  function loadLists() {
    fetch('../api/lookup-lists.php?entity=list&action=list')
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          renderLists(data.lists || []);
        } else {
          showAlert(mainAlert, data.error);
        }
      })
      .catch(() => showAlert(mainAlert, 'Server error'));
  }

  document.getElementById('addListBtn').addEventListener('click', () => {
    listForm.reset();
    document.getElementById('list-id').value = '';
    listModalLabel.textContent = 'Add Lookup List';
    listAlert.innerHTML = '';
    listModal.show();
  });

  listsTableBody.addEventListener('click', e => {
    const target = e.target;
    if (target.classList.contains('edit-list')) {
      document.getElementById('list-id').value = target.dataset.id;
      document.getElementById('list-name').value = target.dataset.name || '';
      document.getElementById('list-description').value = target.dataset.description || '';
      document.getElementById('list-memo').value = target.dataset.memo || '';
      listModalLabel.textContent = 'Edit Lookup List';
      listAlert.innerHTML = '';
      listModal.show();
    } else if (target.classList.contains('delete-list')) {
      if (!confirm('Delete this list?')) return;
      const id = target.dataset.id;
      const formData = new FormData();
      formData.append('entity', 'list');
      formData.append('action', 'delete');
      formData.append('id', id);
      formData.append('csrf_token', csrfToken);
      fetch('../api/lookup-lists.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            loadLists();
          } else {
            showAlert(mainAlert, data.error);
          }
        })
        .catch(() => showAlert(mainAlert, 'Server error'));
    }
  });

  listForm.addEventListener('submit', e => {
    e.preventDefault();
    listLoading.classList.remove('d-none');
    const action = document.getElementById('list-id').value ? 'update' : 'create';
    const formData = new FormData(listForm);
    formData.append('entity', 'list');
    formData.append('action', action);
    fetch('../api/lookup-lists.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
        listLoading.classList.add('d-none');
        if (data.success) {
          showAlert(listAlert, data.message, 'success');
          loadLists();
        } else {
          showAlert(listAlert, data.error);
        }
      })
      .catch(() => {
        listLoading.classList.add('d-none');
        showAlert(listAlert, 'Server error');
      });
  });

  loadLists();
});
</script>
<?php require '../admin_footer.php'; ?>
