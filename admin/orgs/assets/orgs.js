document.addEventListener('DOMContentLoaded', () => {
  const list = document.getElementById('orgList');
  const form = document.getElementById('orgFilterForm');

  function refreshList(params) {
    fetch('index.php?partial=1&' + params.toString())
      .then(r => r.text())
      .then(html => {
        if (list) list.innerHTML = html;
        if (typeof refreshFsLightbox === 'function') {
          refreshFsLightbox();
        }
      });
  }

  if (form) {
    form.addEventListener('submit', e => {
      e.preventDefault();
      const params = new URLSearchParams(new FormData(form));
      refreshList(params);
    });
  }

  document.addEventListener('show.bs.collapse', e => {
    const target = e.target;
    const type = target.dataset.type;
    if (!type || target.dataset.loaded) return;
    const parentId = target.dataset.parentId;
    const url = type === 'agencies' ? 'functions/get_agencies.php' : 'functions/get_divisions.php';
    const params = new URLSearchParams({ parent_id: parentId, csrf_token: csrfToken });
    fetch(`${url}?${params.toString()}`)
      .then(r => r.json())
      .then(data => {
        if (data.html) {
          const body = target.querySelector('.accordion-body');
          if (body) body.innerHTML = data.html;
          target.dataset.loaded = 1;
          if (typeof refreshFsLightbox === 'function') {
            refreshFsLightbox();
          }
        }
      });
  });
});

