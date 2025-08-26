document.addEventListener('DOMContentLoaded', () => {
  const cabinet = document.getElementById('file-cabinet');
  if (!cabinet) return;
  const listUrl = cabinet.dataset.listEndpoint;
  const uploadUrl = cabinet.dataset.uploadEndpoint;
  const moveUrl = cabinet.dataset.moveEndpoint;
  const projectId = cabinet.dataset.projectId;
  const maxDepth = parseInt(cabinet.dataset.maxDepth || '0', 10);

  const tableBody = cabinet.querySelector('tbody');
  const breadcrumbs = cabinet.querySelector('#fc-breadcrumbs');
  const searchInput = cabinet.querySelector('#fc-search');

  let path = [];

  function updateBreadcrumbs() {
    breadcrumbs.innerHTML = '';
    const root = document.createElement('li');
    root.className = 'breadcrumb-item' + (path.length === 0 ? ' active' : '');
    if (path.length === 0) {
      root.textContent = 'Root';
    } else {
      const a = document.createElement('a');
      a.href = '#';
      a.textContent = 'Root';
      a.addEventListener('click', e => {
        e.preventDefault();
        path = [];
        updateBreadcrumbs();
        fetchList();
      });
      root.appendChild(a);
    }
    breadcrumbs.appendChild(root);
    path.forEach((seg, idx) => {
      const li = document.createElement('li');
      li.className = 'breadcrumb-item';
      if (idx === path.length - 1) {
        li.classList.add('active');
        li.textContent = seg;
      } else {
        const a = document.createElement('a');
        a.href = '#';
        a.textContent = seg;
        a.addEventListener('click', e => {
          e.preventDefault();
          path = path.slice(0, idx + 1);
          updateBreadcrumbs();
          fetchList();
        });
        li.appendChild(a);
      }
      breadcrumbs.appendChild(li);
    });
  }

  function render(files) {
    tableBody.innerHTML = '';
    files.forEach(f => {
      const tr = document.createElement('tr');
      tr.draggable = true;
      tr.dataset.id = f.id;
      tr.dataset.type = f.type;
      tr.innerHTML = `<td class="name"><span class="fa-solid ${f.type === 'folder' ? 'fa-folder text-warning' : 'fa-file text-secondary'} me-2"></span>${f.name}</td>
        <td>${f.type}</td>
        <td>${f.size || ''}</td>
        <td>${f.modified || ''}</td>`;
      tableBody.appendChild(tr);
      if (f.type === 'folder') {
        tr.addEventListener('dblclick', () => {
          path.push(f.name);
          updateBreadcrumbs();
          fetchList();
        });
      }
    });
  }

  function fetchList() {
    const url = `${listUrl}?project_id=${encodeURIComponent(projectId)}&path=${encodeURIComponent(path.join('/'))}`;
    fetch(url)
      .then(r => r.json())
      .then(d => render(d.files || []));
  }

  searchInput.addEventListener('input', () => {
    const term = searchInput.value.toLowerCase();
    Array.from(tableBody.rows).forEach(row => {
      const name = row.querySelector('.name').textContent.toLowerCase();
      row.style.display = name.includes(term) ? '' : 'none';
    });
  });

  cabinet.querySelectorAll('th.sortable').forEach(th => {
    th.style.cursor = 'pointer';
    th.addEventListener('click', () => {
      const idx = th.cellIndex;
      const asc = th.classList.toggle('asc');
      const rows = Array.from(tableBody.querySelectorAll('tr'));
      rows.sort((a, b) => {
        const ta = a.children[idx].textContent.trim();
        const tb = b.children[idx].textContent.trim();
        return asc ? ta.localeCompare(tb) : tb.localeCompare(ta);
      });
      rows.forEach(r => tableBody.appendChild(r));
    });
  });

  tableBody.addEventListener('dragstart', e => {
    const row = e.target.closest('tr');
    if (row) e.dataTransfer.setData('text/plain', row.dataset.id);
  });
  tableBody.addEventListener('dragover', e => { e.preventDefault(); });
  tableBody.addEventListener('drop', e => {
    e.preventDefault();
    const target = e.target.closest('tr');
    const fileId = e.dataTransfer.getData('text/plain');
    if (target && target.dataset.type === 'folder') {
      fetch(moveUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: fileId, parent: target.dataset.id })
      }).then(() => fetchList());
    }
  });

  if (window.Dropzone) {
    new Dropzone('#file-cabinet-dropzone', {
      url: uploadUrl,
      params: { project_id: projectId },
      init: function() {
        this.on('sending', (file, xhr, formData) => {
          formData.append('path', path.join('/'));
        });
        this.on('queuecomplete', () => fetchList());
      }
    });
  }

  cabinet.querySelectorAll('[data-create-folder]').forEach(btn => {
    btn.addEventListener('click', () => {
      if (maxDepth && path.length >= maxDepth) {
        alert(`Maximum folder depth of ${maxDepth} reached`);
        return;
      }
      const name = prompt('Folder name');
      if (!name) return;
      fetch(moveUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ create: true, path: path.join('/'), name })
      }).then(() => fetchList());
    });
  });

  updateBreadcrumbs();
  fetchList();
});
