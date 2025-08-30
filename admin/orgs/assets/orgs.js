// Handles hierarchy loading, filters, and person assignment modals

document.addEventListener('DOMContentLoaded', () => {
  const listEl = document.getElementById('orgList');
  if (listEl) {
    const orgList = new List('orgList', { valueNames: ['org-name', 'org-status'] });
    const statusFilter = document.getElementById('statusFilter');
    const orgFilter = document.getElementById('orgFilter');
    const applyFilters = () => {
      const status = statusFilter ? statusFilter.value : '';
      const orgId = orgFilter ? orgFilter.value : '';
      orgList.filter(item => {
        const matchesStatus = !status || item.values()['org-status'] === status;
        const matchesOrg = !orgId || item.elm.dataset.orgId === orgId;
        return matchesStatus && matchesOrg;
      });
    };
    if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    if (orgFilter) orgFilter.addEventListener('change', applyFilters);
  }

  document.addEventListener('show.bs.collapse', e => {
    const target = e.target;
    const type = target.dataset.type;
    if (!type || target.dataset.loaded) return;
    const parentId = target.dataset.parentId;
    fetch(`index.php?ajax=${type}&parent_id=${parentId}`)
      .then(r => r.text())
      .then(html => {
        const body = target.querySelector('.accordion-body');
        if (body) body.innerHTML = html;
        target.dataset.loaded = 1;
        if (typeof refreshFsLightbox === 'function') {
          refreshFsLightbox();
        }
      });
  });

  document.querySelectorAll('.assign-person-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      fetch(form.action, { method: 'POST', body: new FormData(form) })
        .then(r => r.json())
        .then(data => {
          if (data.success && data.row) {
            const targetBody = document.getElementById(form.dataset.target);
            if (targetBody) {
              targetBody.insertAdjacentHTML('beforeend', data.row);
            }
            form.reset();
            const modalEl = document.getElementById(form.dataset.modal);
            if (modalEl) {
              const modal = bootstrap.Modal.getInstance(modalEl);
              if (modal) modal.hide();
            }
          } else if (data.error) {
            alert(data.error);
          }
        });
    });
  });

  document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-person')) {
      e.preventDefault();
      const btn = e.target;
      const url = btn.dataset.url;
      const formData = new FormData();
      formData.append('assignment_id', btn.dataset.assignmentId);
      formData.append('csrf_token', btn.dataset.csrf);
      fetch(url, { method: 'POST', body: formData })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            const row = btn.closest('tr');
            if (row) row.remove();
          } else if (data.error) {
            alert(data.error);
          }
        });
    }
  });
});
