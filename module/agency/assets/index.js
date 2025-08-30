document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('agency-filter-form');
  const results = document.getElementById('agency-results');
  if (!form || !results) return;

  function attachNavHandlers() {
    results.querySelectorAll('nav a').forEach(a => {
      a.addEventListener('click', e => {
        e.preventDefault();
        const url = new URL(a.href);
        const action = url.searchParams.get('action') || 'card';
        const actionField = form.querySelector('input[name="action"]');
        if (actionField) actionField.value = action;
        submitForm();
      });
    });
  }

  function submitForm() {
    const params = new URLSearchParams(new FormData(form));
    const qs = params.toString();
    fetch('index.php?ajax=1&' + qs, {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(r => r.text())
      .then(html => {
        results.innerHTML = html;
        attachNavHandlers();
        if (typeof refreshFsLightbox === 'function') {
          refreshFsLightbox();
        }
        history.replaceState(null, '', 'index.php?' + qs);
      })
      .catch(err => console.error('Agency AJAX error:', err));
  }

  form.addEventListener('submit', e => {
    e.preventDefault();
    submitForm();
  });

  form.addEventListener('change', () => submitForm());

  attachNavHandlers();
});

