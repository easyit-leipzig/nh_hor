document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('siteSearchInput');
  const results = document.getElementById('siteSearchResults');
  const form = input ? input.closest('form') : null;
  if (!input || !results || !form || !window.EASYIT_SEARCH_INDEX) return;

  const actionPath = new URL(form.action, window.location.href).pathname;
  const basePath = actionPath.endsWith('/suche.php')
    ? actionPath.slice(0, -'/suche.php'.length)
    : '';

  const publicUrl = value => `${basePath}/${String(value).replace(/^\/+/, '')}`;
  const escapeHtml = value => String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');

  const normalize = value => value.toLocaleLowerCase('de-DE')
    .normalize('NFD').replace(/\p{Diacritic}/gu, '');

  input.addEventListener('input', () => {
    const query = normalize(input.value.trim());
    if (query.length < 2) {
      results.innerHTML = '';
      results.hidden = true;
      return;
    }

    const tokens = query.split(/\s+/).filter(Boolean);
    const matches = window.EASYIT_SEARCH_INDEX.filter(item => {
      const haystack = normalize(`${item.title} ${item.keywords}`);
      return tokens.every(token => haystack.includes(token));
    }).slice(0, 8);

    results.innerHTML = matches.length
      ? matches.map(item => {
          const url = publicUrl(item.url);
          return `<li><a href="${escapeHtml(url)}"><strong>${escapeHtml(item.title)}</strong><span>${escapeHtml(item.url)}</span></a></li>`;
        }).join('')
      : '<li class="search-empty">Keine passende Seite gefunden.</li>';

    results.hidden = false;
  });

  document.addEventListener('click', event => {
    if (!event.target.closest('.site-search')) {
      results.hidden = true;
    }
  });

  input.addEventListener('keydown', event => {
    if (event.key === 'Escape') {
      results.hidden = true;
      input.blur();
    }
  });
});
